#!/bin/ash

rm -f output.txt
php blocks.php < input.txt > output.txt
diff output.txt output_expected.txt
if [ "$?" -eq "0" ]; then
   echo "# a-ok";
   exit;
fi
echo "# fail!"
