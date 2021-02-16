<?php 

namespace App\Services;

use App\Repositories\ProdutoRepository;

class ProdutoService 
{
    protected $produtoRepository;

    public function __construct()
    {
        $this->produtoRepository = new ProdutoRepository();
    }

    public function find($id, array $with = [])
    {
        return $this->produtoRepository->find($id,$with);
    }

    public function findAll(array $with = [], array $orderBy = [])
    {
        return $this->produtoRepository->findAll($with,$orderBy);
    }

    public function create(array $data)
    {
        return $this->produtoRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->produtoRepository->update($data,$id);
    }

    public function delete($_delete)
    {
        return $this->produtoRepository->delete($_delete);
    }

    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [], array $between = [], $paginate = null)
    {
        return $this->produtoRepository->findBy($where,$with, $orderBy, $groupBy , $limit , $offset,  $selects , $between , $paginate);
    }

    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }

    public function verificaEstoque($id,$qtd)
    {
        $buscaItem = $this->produtoRepository->find($id);
        return $buscaItem->quantidade_estoque < $qtd ? false : true;
    }

    public function processaImportacao($codigo,$variacao,$preco,$peso,$grupo,$descricao,$estoque,$atualizar)
    {
        $grupoService = new GrupoProdutoService();
        //Verifica Existencia do grupo
        $buscaGrupo = $grupoService->findBy(
            [
                ['nome','=',$grupo]
            ],
        );
        
        if($buscaGrupo->count() > 0){
            $idGrupo = $buscaGrupo[0]->id;
        }else{
            //cadastra
            $retornoCreateGrupo = $grupoService->create(
                [
                'nome'    =>$grupo,
                'inativo' => 0
                ]
            );
            $idGrupo = $retornoCreateGrupo->id;
        }

        //verifica Existencia do produto
        $buscaProduto = self::findBy(
            [
                ['produto_terceiro_id','=',$codigo]
            ],
        );

        if($buscaProduto->count() > 0 && $atualizar == 1){
            //ativa produto
            $update = self::montaRequestImportProduto($codigo,$variacao,$preco,$peso,$idGrupo,$descricao,$estoque);
            
            self::update(
                $update,
                $buscaProduto[0]->id
            );
        }else if($buscaProduto->count() == 0){
            
            //cadastra produto
            $cadastro = self::montaRequestImportProduto($codigo,$variacao,$preco,$peso,$idGrupo,$descricao,$estoque);
            
            $retornoCreateProduto = self::create(
               $cadastro
            );
            
        }


    }

    public function montaRequestImportProduto($codigo,$variacao,$preco,$peso,$idGrupo,$descricao,$estoque)
    {
        $produto = [
            'nome'               => $descricao,
            'produto_terceiro_id'=> $codigo,
            'inativo'            => 0,
            'grupo_produto_id'   => $idGrupo,
            'variacao'           => $variacao ?? 0,
            'peso'               => $peso ?? 0,
            'quantidade_estoque' => $estoque,
            'valor'              => str_replace(',','.',$preco),
            'tamanho'            => ''
        ];

        return $produto;
    }

    public function inativarTodosProdutos()
    {
        //busca produtos que q estejam ativos cadastrados
        $produtosAtivos = self::findBy(
            [
                [
                    'inativo', '=' , 0
                ]
            ]
        );

        foreach ($produtosAtivos as $key => $valueProdutosAtivos) {
                       

            self::update(
                ['inativo'=>'1'],
                $valueProdutosAtivos->id
            );
        }
    }
}