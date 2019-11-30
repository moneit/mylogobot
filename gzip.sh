#!/bin/bash

FILES="./public/css/*.css"

for f in $FILES
do
    echo "Processing css file $f"
    gzip -c "$f" > "${f}.gz"
done

FILES="./public/css/icomoon/*.css"

for f in $FILES
do
    echo "Processing css file $f"
    gzip -c "$f" > "${f}.gz"
done

FILES="./public/js/*.js"

for f in $FILES
do
    echo "Processing js file $f"
    gzip -c "$f" > "${f}.gz"
done

FILES="./public/img/*.svg"

for f in $FILES
do
    echo "Processing svg file $f"
    gzip -c "$f" > "${f}.gz"
done