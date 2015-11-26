#!/usr/bin/env python
#-*- coding:utf8 -*-
__author__ = 'saintic.com'
__date__ = '2015-08-25'
__doc__ = '节点信息,测试支持RHEL系列,不承诺系统Linux发行版。'
__version__ = '2.0'

import platform,commands,os,subprocess,re,sys
from random import Random

class SysInfo():
  '''get system info'''
  i=platform.uname()
  v=platform.linux_distribution()
  sys_type=v[0] + ' ' + v[1] + ' ' + v[2]  #eg:CentOS 6.5 Final
  sys_fqdn=i[1]   #hostname,eg:localhost.localdomain
  sys_kernel=i[2] #kernel version
  sys_arch=i[4]   #eg:x86_64 amd64 win32

  def CPU(self):
    CPU_Label=str(commands.getoutput('grep "model name" /proc/cpuinfo | awk -F ": " \'{print $2}\' | head -1'))
    CPU_NUMS=int(commands.getoutput('grep "model name" /proc/cpuinfo | awk -F ": " \'{print $2}\' | wc -l'))
    CPU_Cache_size=str(commands.getoutput('grep "cache size" /proc/cpuinfo|uniq|awk \'{print $4,$5}\''))
    return {"Label":CPU_Label, "Cores":CPU_NUMS, "Cache_size":CPU_Cache_size}

  def Kernel(self):
    return {"Kernel":self.sys_kernel}

  def Arch(self):
    return {"Arch":self.sys_arch}

  def Mem(self):
    __MemTotal=int(commands.getoutput('expr $(grep "MemTotal" /proc/meminfo | awk -F "MemTotal:" \'{print $2}\' | awk \'{print $1}\') / 1024'))
    __MemFree=int(commands.getoutput('expr $(grep "MemFree" /proc/meminfo | awk -F "MemFree:" \'{print $2}\' | awk \'{print $1}\') / 1024'))
    __MemBuffers=int(commands.getoutput('expr $(grep "Buffers" /proc/meminfo | awk -F "Buffers:" \'{print $2}\' | awk \'{print $1}\') / 1024'))
    __MemCached=int(commands.getoutput('expr $(grep "Cached" /proc/meminfo |head -1| awk -F "Cached:" \'{print $2}\' | awk \'{print $1}\') / 1024'))
    __SwapCached=int(commands.getoutput('expr $(grep "SwapCached" /proc/meminfo | awk -F "SwapCached:" \'{print $2}\' | awk \'{print $1}\') / 1024'))
    __MemUsedPerc=100 * (__MemTotal - __MemFree - __MemCached - __MemBuffers) / __MemTotal
    memtotal=str(__MemTotal)+'M'
    memfree=str(__MemFree)+'M'
    memused=str(__MemUsedPerc)+'%'
    return {"Total":memtotal, "Free":memfree, "UsageRate":memused}

  def Version(self):
    return {"SysVersion": self.sys_type}

def ChangeHostName():
  '''Get Hostname, and Contrast the command "hostname" & network'''
  #pre_host
  stri = ''
  chars = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789'
  length = len(chars) - 1
  random = Random()
  for i in range(12):
    stri+=chars[random.randint(0, length)]
  #get hostname through file and command
  h1=commands.getoutput('grep "HOSTNAME" /etc/sysconfig/network').split('=',)[1]
  h2=platform.uname()[1] #command
  if h1 != h2:
    print '异常，原因是获取主机名时文件与命令行结果不一致，请保证结果一致！'
    print '请检查/etc/sysconfig/network(HOSTNAME)与hostname命令结果。'
    return 1
  else:
    #检测主机名是否合法
    if re.match(r'[0-9a-zA-Z\_\-]+\.saintic.com$', h1) == None:
      nodehost=stri+'.saintic.com'
      os.environ['host']=str(nodehost)
      os.system('sed -i "s/\(HOSTNAME=\).*/HOSTNAME=${host}/" /etc/sysconfig/network')
      os.system('sed -i "s/\(127.0.0.1\).*/127.0.0.1 ${host}/" /etc/hosts')
      os.system('sed -i "s/\(::1\).*/::1 ${host}/" /etc/hosts')
      return nodehost

if __name__ == '__main__':
  info=SysInfo()
  print info.sys_fqdn
  print info.CPU()
  print info.Mem()
  print info.Arch()
  print info.Kernel()
  print info.Version()

