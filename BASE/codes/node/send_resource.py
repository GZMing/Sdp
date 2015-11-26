#!/usr/bin/env python
#-*- coding:utf8 -*-
__author__ = 'saintic.com'
__date__ = '2015-08-25'
__doc__ = '客户端，定时探测服务器端证明节点存活并发送节点信息。'
__version__ = '2.0'

import socket,json
import GetNodeInfo
ip=socket.gethostbyname(socket.gethostname())
#keep hostname unchange, set GetNodeInfo.py
hostname=str(GetNodeInfo.ChangeHostName())
info=GetNodeInfo.SysInfo()

nodeinfo = (
hostname, ip, {
"CPU": info.CPU(),
"MEM": info.Mem(),
"ARCH": info.Arch(),
"KERNEL": info.Kernel(),
"VERSION": info.Version()
})

addr=('182.92.106.104', 1000)  #console center ip:port
try:
  s=socket.socket(socket.AF_INET, socket.SOCK_STREAM)
  s.connect(addr)
  #data=s.recv(1024)
  s.send(json.dumps(nodeinfo))
  s.send('exit')
  s.close()
except:
  print 'Connection Error.'
finally:
  print 'Connection Over.'
