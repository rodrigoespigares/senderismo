CREATE USER 'pDiciembre'@'localhost' IDENTIFIED BY 'cXrpJBft5i';
GRANT ALL PRIVILEGES ON senderismo.* TO 'pDiciembre'@'localhost';
FLUSH PRIVILEGES;
/* % para todas las conexiones, sino localhost o uno especifico SOLO EN CASO DE NO PODER ACCEDER*/
ALTER USER 'pDiciembre'@'localhost' IDENTIFIED WITH mysql_native_password BY 'cXrpJBft5i';