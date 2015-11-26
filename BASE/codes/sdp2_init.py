#!/usr/bin/env python
#-*- coding=utf-8 -*-

__author__ = 'saintic.com'
__doc__ = '初始化安装，包括基本系统、控制系统、健康监测系统。'
__date__ = '2015-08-24'
__version = '2.0'

import os,sys,commands,platform

ROOT=sys.path[0]
os.environ['ROOT']=str(ROOT)

def docker_check():
  '''docker check or install'''
  if commands.getstatusoutput('which docker')[0] == 0:
    print "Docker has been installed!"
  elif commands.getstatusoutput('ps aux | grep -v grep | grep docker')[0] == 0:
    print "Docker has been installed!"
  else:
    print "未安装Docker服务，可能的原因是搜索不到Docker命令或尚未安装Docker服务!"
    print '将执行Docker安装脚本'
    di=os.system("sh ${ROOT}/../codes/BaseScripts/docker.sh")
    if di == 0:
      return "Docker has been installed successfully!"
    else:
      return "Please Check the Script:", ROOT + "/../codes/BaseScripts/docker.sh"

def nginx_check():
  '''nginx check or install'''
  if commands.getstatusoutput('which nginx')[0] == 0:
    print "Nginx has been installed!"
  elif commands.getstatusoutput('ps aux | grep -v grep | grep nginx')[0] == 0:
    print "Nginx has been installed!"
  else:
    print "未安装Nginx服务，可能的原因是搜索不到nginx命令或尚未安装Nginx服务!"
    print '将执行Nginx安装脚本'
    ni=os.system("sh ${ROOT}/../codes/BaseScripts/nginx.sh")
    if ni == 0:
      return "Nginx has been installed successfully!"
    else:
      return "Please Check the Script:", ROOT + "/../codes/BaseScripts/nginx.sh"

def svn_check():
  '''Subversion check or install'''
  if commands.getstatusoutput('which svn')[0] == 0:
    print "Subversion has been installed!"
  elif commands.getstatusoutput('ps aux | grep -v grep | grep svn')[0] == 0:
    print "Subversion has been installed!"
  else:
    print "未安装Subversion服务，可能的原因是搜索不到svn命令或尚未安装Subversion服务!"
    print '将执行Subversion安装脚本'
    ni=os.system("sh ${ROOT}/../codes/BaseScripts/svn.sh")
    if ni == 0:
      return "Subversion has been installed successfully!"
    else:
      return "Please Check the Script:", ROOT + "/../codes/BaseScripts/svn.sh"

def vsftpd_check():
  '''vsftpd check or install'''
  if commands.getstatusoutput('which vsftpd')[0] == 0:
    print "Vsftpd has been installed!"
  elif commands.getstatusoutput('ps aux | grep -v grep | grep vsftpd')[0] == 0:
    print "Vsftpd has been installed!"
  else:
    print "未安装vsftpd服务，可能的原因是搜索不到svn命令或尚未安装vsftpd服务!"
    print '将执行vsftpd安装脚本'
    ni=os.system("sh ${ROOT}/../codes/BaseScripts/vsftpd.sh test www.saintic.com")
    if ni == 0:
      return "vsftpd has been installed successfully!"
    else:
      return "Please Check the Script:", ROOT + "/../codes/BaseScripts/vsftpd.sh"

if __name__ == '__main__':
  sys_v=platform.linux_distribution()[0]
  if sys_v == 'CentOS' or sys_v == 'Red Hat Enterprise Linux Server':
    r=os.system('yum -y install mailx jq expect python python-pip;pip install redis')
    if r != 0:
      print "ErrorCode[%d]:软件包安装失败，请安装mailx jq expect python python-pip及Python第三方模块redis" % r
  else:
    print 'Unsupported operating system type.'
  docker_check()
  nginx_check()
  svn_check()
  vsftpd_check()
