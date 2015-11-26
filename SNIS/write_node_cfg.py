#!/usr/bin/env python
#coding:utf8
__author__ = 'saintic.com'
__date__ = '2015.09.13'
__doc__ = 'write nodes.cfg'

import sys,os
ROOT=sys.path[0]
nodes_pub_cfg = {
  "nodes_home": os.path.join(ROOT."conf"),
  "tpl_home": os.path.join(ROOT,"tpl")
}

with open(ROOT+'/nodes_pub.py','w') as node:
  node.write(str(nodes_pub_cfg))


