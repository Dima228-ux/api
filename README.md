Настройка проекта:
Если ОС Widows то достаточно  поставить в OpenServer в папку domains папку проекта

Если Linux:
использовать nginx конфиг 
для локального развертывания : local
для прода: prod
выполнить доп настройку в случае возникновения ошибок

Настроить подключение в классе BasePdo
![img.png](img.png)

взять дамп базы:
test_group.sql

Примеры:
1) Запрос для получения групп и их прав:
METHOD: GET Url: http://api/group/getGroups
response:
![img_1.png](img_1.png)
2) Запрос для получения информации о пользователе:
METHOD GET URL:http://api/group/getUser?id=1
response:
![img_2.png](img_2.png)
    
3) Запрос для добовления пользователя в группу:
METHOD: POST URL: http://api/group/insertUser
   request:
   
   ![img_3.png](img_3.png)
   
   response:
   ![img_4.png](img_4.png)
   
4) Запрос для удаления пользователя из группы:
METHOD DELETE URL:
   http://api/group/deleteUser?id_user=1&id_group=4
   response:
   ![img_5.png](img_5.png)