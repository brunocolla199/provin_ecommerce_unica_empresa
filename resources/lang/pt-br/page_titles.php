<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Linhas de Linguagem - Título das páginas
    |--------------------------------------------------------------------------
    |
    | Este arquivo foi criado com o objetivo de armazenar todas os títulos
    | das páginas que serão criadas, sejam títulos principais, subtítulos
    | ou mesmo o que exibir nas tabs do navegador.
    |
    */

    'general'       => [
        'home'      => 'Página Inicial'
    ],


    /** CADASTROS */
    'enterprise'                => [
        'index'                 => 'Empresas',
        'create'                => 'Nova Empresa',
        'update'                => 'Alterando Empresa ',
    ],
    
    'group'                 => [
        'index'             => 'Grupos',
        'create'            => 'Novo Grupo',
        'update'            => 'Alterando Grupo ',     
    ],

    'cidade'                 => [
        'index'             => 'Cidades',
        'create'            => 'Nova Cidade',
        'update'            => 'Alterando Cidade ',  
    ],
    

    'user'              => [
        'index'         => 'Usuários',
        'create'        => 'Novo Usuário',
        'update'        => 'Alterando Usuário ',
        'person_info'   => 'Informações pessoais',
        'password'      => 'Senha'
    ],

    'tipoPedido'        => [
        'index'         => 'Tipos de Pedido',
        'create'        => 'Novo Tipo de Pedido',
        'update'        => 'Alterando Tipo de Pedido',
    ],

    'statusPedido'        => [
        'index'         => 'Status do Pedido',
        'create'        => 'Novo Status do Pedido',
        'update'        => 'Alterando Status do Pedido',
    ],

    'condicaoPagamento'        => [
        'index'         => 'Condições de Pagamento',
        'create'        => 'Nova Condição de Pagamento',
        'update'        => 'Alterando Condição de Pagamento',
    ],

    'statusPagamento'        => [
        'index'         => 'Status de Pagamento',
        'create'        => 'Novo Status de Pagamento',
        'update'        => 'Alterando Status de Pagamento',
    ],

    'grupoProduto'        => [
        'index'         => 'Grupos de Produto',
        'create'        => 'Novo Grupo de Produto',
        'update'        => 'Alterando Grupo de Produto',
    ],

    'categoriaProduto'        => [
        'index'         => 'Categorias de Produto',
        'create'        => 'Nova Categoria de Produto',
        'update'        => 'Alterando Categoria de Produto',
    ],

    'setup'             => [
        'index'         => 'Configurações'

    ],

    'dashboard'         => [
        'index'         => 'Dashboard'
    ],

    'listagemProduto'   => [
        'index'         => 'Listagem de Produtos'
    ],

    'detalheProduto'    => [
        'index'         => 'Detalhe do Protuto'
    ],
    

    /** LOGS */
    'logs'              => [
        'index'         => 'Logs',
        'list'          => 'Atividades Encontradas',
        'instruction'   => 'Informe o período desejado para realizar a busca',
        'warning'       => 'Esteja ciente que buscas com período maior que 15 dias serão mais lentas e que o período máximo é 3 meses!',
        'empty'         => 'Não foram encontrados registros com os valores pesquisados!',
    ],



    //PERFIL
    'perfil'        => [
        'index'           => 'Perfis',
        'create'          => 'Novo Perfil',
        'update'          => 'Alterando Perfil',
    ],

    //PRODUTO
    'produto'        => [
        'index'           => 'Produtos',
        'create'          => 'Novo Produto',
        'update'          => 'Alterando Produto',
    ],

    //Pedido
    'pedido'        => [
        'index'           => 'Pedidos',
        'create'          => 'Novo Pedido',
        'update'          => 'Alterando Pedido',
    ],



    //ECOMMERCE
    'ecommerce'    => [
        
        'home'     => [
            'index'  => 'Home'
        ],

        'produto'     => [
            'index'  => 'Produtos'
        ],
        'detalheProduto'     => [
            'index'  => 'Det. do Produto',
            'descAneis' => 'Os anéis estão disponíveis nos tamanhos'
        ],
        'carrinho'     => [
            'index'  => 'Carrinho de Compras'
        ],
        'checkout'     => [
            'index'  => 'Checkout'
        ],

        'pedido'     => [
            'index'  => 'Pedidos'
        ],
        'detalhePedido'     => [
            'index'  => 'ver detalhes'
        ],
        'telaDetalhesPedido'     => [
            'index'  => 'Det. do Pedido'
        ],
        'checkout'     => [
            'index'  => 'Checkout de Compras'
        ],
        'estoque'     => [
            'index'  => 'Consulta de Estoque'
        ],
        'dashboard'     => [
            'index'  => 'Dashboards'
        ],
        'detalheCarrinho'     => [
            'index'  => [
                'normal'  => 'Det. do item da Sacola',
                'express' => 'Det. do item da Sacola Expressa'
            ]
        ]
    ]
];
