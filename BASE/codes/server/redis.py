#!/usr/bin/env python
#-*- coding:utf8 -*-
__author__ = 'saintic.com'
__date__ = '2015-09-18'
__doc__ = 'design from argvs'
__version__ = '2.0'

class ActionRedis:
  import redis,sys
  __conn=redis.Redis(host='127.0.0.1',port=6379,db=9,password=None)
  def node_add(self):
    pass
  def node_del(self):
    pass    

if len(sys.argv) == 4:
  cid=sys.argv[2]
  cip=sys.argv[3]
  if sys.argv[1] == start:
    set_kv(cid,cip)
  elif sys.argv[1] == restart:
    get_kv(cid)
