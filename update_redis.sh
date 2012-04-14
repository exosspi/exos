#!/bin/bash

# This script is also the post-merge hook


for folder in `ls src`
do
    for file in `ls src/$folder`
    do
        file_uniq_name="$folder/$file"
        echo "+-> Adding line for key : $file_uniq_name"
        line=`head -n 1 src/$folder/$file | grep ^# | cut -d '#' -f 2`
        redis-cli SET exosfac:$file_uniq_name "$line"
        #redis-cli SET exosfac:$file_uniq_name "$line"
    done
done
