#!/bin/bash
#user/passwd/service/file->user.file->dns.map->docker.service
#everythin is file.user/passwd、ip_port(expose docker)、docker_map
#retrun: $0 successful, user passwd IP:Port(DNS) service file_directory.
export SDP_HOME=$(cd `dirname $0`; pwd)
rpm -q subversion &> /dev/null || sh $SDP_HOME/components/svn.sh
rpm -q vsftpd &> /dev/null || sh $SDP_HOME/components/vsftpd.sh
if [ "$#" != "4" ]; then
  echo "Usage: $0 user passwd service file_type" ; exit 1
else
  :
fi
source $SDP_HOME/global.func
export INIT_HOME=/data/SDI.PaaS
export init_user=$1
export init_passwd=$2
export init_service_type=$3
export init_file_type=$4
export portmap_file=${INIT_HOME}/portmap           #file
export Sdp=${INIT_HOME}/Sdp.user.info              #file
export init_user_home=${INIT_HOME}/$init_user      #directory
export init_user_home_info=${INIT_HOME}/${init_user}/info   #file
export init_user_home_root=${INIT_HOME}/${init_user}/root   #directory

if [ "$init_file_type" != "svn" ] || [ "$init_file_type" != "ftp" ] || [ "$init_file_type" != "-"  ]; then
  echo -e "\033[31mUnsupported code type！\033[0m"
  echo -e "\033[31mAsk:svn,ftp,-\033[0m"
  exit 1
fi

[ -d $INIT_HOME ] || mkdir -p ${INIT_HOME}/$init_user
[ -f $Sdp ] || touch $Sdp
[ -f $portmap_file ] || touch $portmap_file
[ -d $init_user_home_info ] || mkdir -p $init_user_home_root
[ -f $init_user_home_info ] || touch  $init_user_home_info

#user_oid:Existing User ID
user_oid=$(grep user_id $Sdp | tail -1 | awk -F : '{print $2}')
if [ -z $user_oid ] || [ "$user_oid" = "" ]; then
  export user_id=1
  echo "50000" > $portmap_file
else
  export user_id=`expr $user_oid + 1`
  echo `expr 50000 + $user_oid` > $portmap_file
  #first portmap is 5000, and portmap = portmap + user_id
  #firsh user_id is 1, and user_id = user_id + 1
fi

source $SDP_HOME/boot/user.file.sh
