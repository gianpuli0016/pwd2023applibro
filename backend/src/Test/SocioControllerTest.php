<?php

declare(strict_types=1);

namespace Raiz\Test;

use Monolog\Test\TestCase;
use Raiz\Bd\SocioDAO;
use Raiz\Controllers\SocioController;
use Raiz\Models\Socio;
use DateTime;

final class SocioControllerTest extends TestCase
{

  /** @Test */
  public function testCrear()
  {

    $fecha = DateTime::createFromFormat('d/m/Y', '20/08/2022');
    $socio = new Socio(001, 39876543, "Guillermo Santolaria", $fecha, 1, 2920332345, "alvear 234");
    $parametros = $socio->serializar();
    SocioController::crear($parametros);
    var_dump(SocioController::listar());
    $socioEncontrado = SocioController::encontrarUno("100");
    $this->assertEquals($parametros, $socioEncontrado);
  }

  /** @Test */
  /*public function testBorrar(){
        SocioController::borrar("100");
        $socioEncontrado = SocioController::encontrarUno("100");
        $this->assertNull($socioEncontrado);

     }*/
}
