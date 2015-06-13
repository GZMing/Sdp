#!/bin/bash
#Save to file for user and passwd > $init_user_home/info #file
#init_user_home=${INIT_HOME}/${init_user}
#code:init_user_home_root=${INIT_HOME}/${init_user}/root
source $SDP_HOME/global.func

[ -z $INIT_HOME ] && ERROR
[ -z $init_user ] && ERROR
[ -z $init_passwd ] && ERROR
[ -z $init_file_type ] && ERROR
[ -z $init_user_home ] && ERROR
[ -z $init_user_home_info ] && ERROR
[ -z $init_user_home_root ] && ERROR

if [ "$init_file_type" == "svn" ]; then
  rm -rf $init_user_home_root && svnadmin create $init_user_home_root
  create_svn $init_user $init_passwd $init_user_home_root
elif [ "$init_file_type" == "ftp" ]; then
  create_ftp $init_user $init_passwd $init_user_home_root
else
  echo -e "\033[31mUnsupported code type！\033[0m"
  exit 1
fi

if [ -z $user_oid ] || [ "$user_oid" = "" ];then
  export user_id=1
else
  export user_id=`expr $user_oid + 1`
fi

source $SDP_HOME/boot/docker.sh