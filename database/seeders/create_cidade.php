<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cidade;

;

class create_cidade extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * ======================================================================
         *                          PRODUÇÃO
         * ======================================================================
         */
        
        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');
        $contents = $request->getBody()->getContents();
    
        $ids = array();
        $arr = json_decode($contents, true);
        foreach ($arr as $key => $value) {
            $ids[] = $value["id"];
        }

        foreach ($ids as $key => $value) {
            $request = $client->get('https://servicodados.ibge.gov.br/api/v1/localidades/estados/'.$value.'/municipios');
            $contents = $request->getBody()->getContents();
            
            $arr = json_decode($contents, true);
            foreach ($arr as $key => $cidade) {
                $c = new Cidade();
                $c->nome = $cidade["nome"];
                $c->estado = $cidade["microrregiao"]["mesorregiao"]["UF"]["nome"];
                $c->sigla_estado = $cidade["microrregiao"]["mesorregiao"]["UF"]["sigla"];
                $c->save();
            }
        }
    }
}
