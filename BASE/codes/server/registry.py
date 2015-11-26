#!/usr/bin/env python
#-*- coding:utf8 -*-
__author__ = 'saintic.com'
__date__ = '2015-09-13'
__doc__ = '注册服务端，管理(add,del)节点，加入到redis。'
__version__ = '2.0'

import socket,threading,sys
host = '0.0.0.0'
port = 1001

def HandleFunc(sock, addr):
  '''sock: server <=> client; addr:('client ip', port)'''
  nodeip=sock.getpeername()[0]
  sock.send('Welcome:'+nodeip+'\r\n')
  while True:
    data=sock.recv(1024) #from node data
    if data == 'exit' or not data:
      break
    else:
      #print data,'\n'   #console put
      data=data.replace('exit','')   #使用时必须确保exit是空的
  sock.close()

try:
  s=socket.socket(socket.AF_INET,socket.SOCK_STREAM)
  s.bind((host,port))
  s.listen(5)
  print 'Registry is waiting for connection in %s:%d...' %(host, port)
  while True:
    sock, addr=s.accept()  #waitting status
    t=threading.Thread(target=HandleFunc, args=(sock, addr))
    t.start()
except StandardError as msg:
  print 'Error Info:%s' % msg
  sys.exit(1)


