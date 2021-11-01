<?php


class TurnosModel
{
    private $database;


    public function __construct($database)
    {
        $this->database=$database;
    }
    /*falta agregar el usuario que reserva CON SESSIONES */
    public function procesarTurno($idHospital,$fecha,$idUsuario){

        $sql = "SELECT * FROM `turnos` where hospital='$idHospital' and fecha='$fecha'";
        $sql2= "SELECT `cantidadDeTurnos` FROM `hospitales` WHERE id='$idHospital'";
        $turnosActuales=$this->database->query($sql);
        $cantidadTurnosDiarios=$this->database->query($sql2);
        $this->validacionDeTurno($turnosActuales,$cantidadTurnosDiarios,$idHospital,$fecha,$idUsuario);

    }
    private function extraerTurnosDiarios($cantidadTurnos){
        $turnosDiarios=0;
        foreach ($cantidadTurnos as $actual){
            foreach ($actual as $cantidad){
                $turnosDiarios=$cantidad;
            }
        }
        return $turnosDiarios;
    }
    private function contarTurnos($cantidadTurnosActuales){
        $turnosReservados=0;
        foreach ($cantidadTurnosActuales as $actual){
                $turnosReservados ++;
        }
        return $turnosReservados;
    }

    private function validacionDeTurno($resultado,$cantidadTurnosDiarios,$idHospital,$fecha,$idUsuario){
        if($this->contarTurnos($resultado)<=$this->extraerTurnosDiarios($cantidadTurnosDiarios)){
            $resultado=$this->generarResultado();
            $sql= "INSERT INTO `turnos` (`reserva`, `fecha`, `hospital`, `usuario`,`resultado`) VALUES (NULL, '$fecha', '$idHospital', '$idUsuario','$resultado')";
            $sql2= "update `usuario` set `tipoAceptado`=$resultado where `usuario`='$idUsuario'";
            $this->database->insert($sql);
            $this->database->insert($sql2);
            echo "hola señor '$idUsuario' su autorizacion para los vuelos es el tipo " . $resultado;
            echo "<br><button type='submit'><a href='/home'>Volver</a></button>";
        }else(header("location:http://localhost/Turnos"));
    }

    private function generarResultado(){
        return rand(1,3);
    }
    /* DEMAS METODOS DE turnos*/


}