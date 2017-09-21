<?php

use Illuminate\Database\Seeder;

class cfdiusosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Generando catalogo de usos cfdi
        $cfdiusos[] = array('clave'=>'P01','descripcion'=>'Por definir');
        $cfdiusos[] = array('clave'=>'G01','descripcion'=>'Adquisición de mercancias');
        $cfdiusos[] = array('clave'=>'G02','descripcion'=>'Devoluciones, descuentos o bonificaciones');
        $cfdiusos[] = array('clave'=>'G03','descripcion'=>'Gastos en general');
        $cfdiusos[] = array('clave'=>'I01','descripcion'=>'Construcciones');
        $cfdiusos[] = array('clave'=>'I02','descripcion'=>'Mobilario y equipo de oficina por inversiones');
        $cfdiusos[] = array('clave'=>'I03','descripcion'=>'Equipo de transporte');
        $cfdiusos[] = array('clave'=>'I04','descripcion'=>'Equipo de computo y accesorios');
        $cfdiusos[] = array('clave'=>'I05','descripcion'=>'Dados, troqueles, moldes, matrices y herramental');
        $cfdiusos[] = array('clave'=>'I06','descripcion'=>'Comunicaciones telefónicas');
        $cfdiusos[] = array('clave'=>'I07','descripcion'=>'Comunicaciones satelitales');
        $cfdiusos[] = array('clave'=>'I08','descripcion'=>'Otra maquinaria y equipo');
        $cfdiusos[] = array('clave'=>'D01','descripcion'=>'Honorarios médicos, dentales y gastos hospitalarios');
        $cfdiusos[] = array('clave'=>'D02','descripcion'=>'Gastos médicos por incapacidad o discapacidad');
        $cfdiusos[] = array('clave'=>'D03','descripcion'=>'Gastos funerales.');
        $cfdiusos[] = array('clave'=>'D04','descripcion'=>'Donativos.');
        $cfdiusos[] = array('clave'=>'D05','descripcion'=>'Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación)');
        $cfdiusos[] = array('clave'=>'D06','descripcion'=>'Aportaciones voluntarias al SAR.');
        $cfdiusos[] = array('clave'=>'D07','descripcion'=>'Primas por seguros de gastos médicos.');
        $cfdiusos[] = array('clave'=>'D08','descripcion'=>'Gastos de transportación escolar obligatoria.');
        $cfdiusos[] = array('clave'=>'D09','descripcion'=>'Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.');
        $cfdiusos[] = array('clave'=>'D10','descripcion'=>'Pagos por servicios educativos (colegiaturas)');

        foreach($cfdiusos as $registro){
            \Illuminate\Support\Facades\DB::table('cfdiusos')->insert($registro);
        }
    }
}
