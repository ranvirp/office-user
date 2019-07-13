model=('department')
for i in  "${!model[@]}"; do
   echo "generating for "${model[$i]}
   table=${model[$i]}
   utable="$(tr '[:lower:]' '[:upper:]' <<< ${table:0:1})${table:1}"
   utable=`echo $utable |/usr/local/bin/sed -r 's/([A-Za-z]+)_([a-z]+)/\1\u\2/g'`
   vews=`echo $table |/usr/local/bin/sed -r 's/([A-Za-z]+)_([a-z]+)/\1\2/g'`
   ./yii gii/model --tableName=$table --interactive=0 --overwrite=1 --modelClass=$utable --ns=app\\modules\\users\\models --template='myModel'
   ./yii gii/crud  --interactive=0 --overwrite=1 --baseControllerClass=app\\modules\\users\\Controller --controllerClass=app\\modules\\users\\controllers\\${utable}Controller --enableI18N=1 --modelClass=app\\modules\\users\\models\\$utable --searchModelClass=app\\modules\\users\\models\\${utable}Search --template='myCrud' --viewPath=@app/modules/users/views/$vews
done