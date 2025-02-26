
Masterming Game Server

*********************************************************************************************
Instalación:
1. git clone https://github.com/jeanorta/mastermaind_server.git

2. cd .\mastermaind_server\

3. composer install

4. "Se configura el archivo .env"

5. php artisan migrate

*********************************************************************************************

Es una api sencilla con una una tabla para crear y jugar este juego.

para obtener la lista de partidas creadas se envia una peticion GET vacia a la dirección del servidor.

Para crear una partida se realiza una petición POST con el siguiente valor JSON:

{
  "name": "nombre (optativo)"
}

Para jugar una partida se realiza una petición POST  con el siguiente valor JSON donde el user_code se refiere a el intento del jugador y el id se refiere al id del juego creado:

{
  "user_code": "[\"NARANJA\",\"ROJO\",\"AZUL\",\"AMARILLO\"]",
  "id": 6
}

Los únicos 6 colores posibles para el juego son: 
"AMARILLO", "AZUL", "ROJO", "VERDE", "NARANJA", "VIOLETA"

Se tiene un total de 10 intentos posibles para decifrar el codigo secreto creado en el servidor y por cada intento se enviará un codigo json similar a el siguiente dentro de cada turno jugado:
{
"check_code_1": "[0,2,0,1]"
}

significado:

0 = Este color no se encuentra en el codigo secreto en ninguna posición.
1 = Este color existe dentro del codigo secreto pero está en otra posición.
2 = Este color existe y está en la posición correcta en el codigo secreto.

cuando se obtiene el siguiente codigo {"check_code_1": "[2,2,2,2]"} se termina el juego combiando el status del juego, ganando el jugador y no es posible seguir jugando el mismo juego.

cuando se hacen los 10 intentos termina el juego y el jugador pierde.

El juego te da una puntuación del 1 al 10 dependiendo de cuantas rondas te tomo resolver el código.
