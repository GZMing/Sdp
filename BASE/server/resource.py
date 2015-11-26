#!/usr/bin/env python
#-*- coding:utf8 -*-
__author__ = 'saintic.com'
__date__ = '2015-08-22'
__doc__ = '资源搜集端，接收节点端存活探测和资源信息(JSON)。'
__version__ = '2.0'

import socket,time,threading,sys,os
current_time=time.ctime()
logf = '/var/log/sdp/node_resource.log'
host = '0.0.0.0'
port = 1000
noded="/data/nodes"
if os.path.isdir(noded) == False:
  os.mkdir(noded)
if os.path.isdir("/var/log/sdp") == False:
  os.mkdir("/var/log/sdp")

def HandleFunc(sock, addr):
  '''sock: server <=> client; addr:('client ip', port)'''
  nodeip=sock.getpeername()[0]
  nodef=os.path.join(noded, nodeip)
  sock.send('Welcome:'+nodeip+'\r\n')
  while True:
    data=sock.recv(1024) #from node data
    if data == 'exit' or not data:
      break
    else:
      #print data,'\n'   #console put
      data=data.replace('exit','')   #使用时必须确保exit是空的
      with open(nodef,'w') as f:
        f.write(data)
        f.write('')
  sock.close()
  try:
    with open(logf,'a') as f:
      f.write('%s:Connection from %s closed.\n' %(current_time,addr))
  except StandardError as errmsg:
    print 'Write Error:%s' % errmsg

try:
  s=socket.socket(socket.AF_INET,socket.SOCK_STREAM)
  s.bind((host,port))
  s.listen(5)
  print 'Resource is waiting for connection in %s:%d...' %(host, port)
  while True:
    sock, addr=s.accept()  #waitting status
    t=threading.Thread(target=HandleFunc, args=(sock, addr))
    t.start()
except StandardError as msg:
  print 'Error Info:%s' % msg
  sys.exit(1)


