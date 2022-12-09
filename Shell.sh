#!/bin/bash

clear

IamIs="$(whoami)"
echo I am is "$IamIs"

dateIs="$(date)"
echo Щас "$dateIs"

for (( COUNTER=1; COUNTER<=3; COUNTER++ )); do
     echo $COUNTER
done

if [ $COUNTER == 4 ]
then
  echo уже 4, ёмаё
fi

#с помощью exit сообщаем родительскому процессу, как всё прошло. 0 - значит збс
exit 0