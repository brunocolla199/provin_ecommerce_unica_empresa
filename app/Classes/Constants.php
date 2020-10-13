<?php

namespace App\Classes;

class Constants {

    // NUNCA ALTERE ESSE ARRAY! (ou, se o fizer, revise as regras de negócio do sistema e seus bloqueios -> mas é REVISAR mesmo viu?!)
    public static $ARR_SUPER_ADMINISTRATORS_ID = [
        1
    ];


    public static $INDICES_OCULTOS = [
        'criadorRegistro', 'Data_do_registro'
    ];

    public static $INDICES_OCULTOS_LOGS = [
        'criadorRegistro', 'Data_do_registro', 'ultimaModificacaoRegistro'
    ];


    public static $INDICES_MANTIDOS = [
        'Nome_do_documento', 'Tipo'
    ];

    public static $EXTENSAO_ONLYOFFICE = ["pdf", "djvu", "xps","docx", "xlsx", "csv", "pptx", "txt","docm", "doc", "dotx", "dotm", "dot", "odt", "fodt", "ott", "xlsm", "xls", "xltx", "xltm", "xlt", "ods", "fods", "ots", "pptm", "ppt", "ppsx", "ppsm", "pps", "potx", "potm", "pot", "odp", "fodp", "otp", "rtf", "mht", "html", "htm", "epub"];
    public static $EXTENSAO_IMAGEM = ["png","jpeg","jpg","gif","svg"];
    public static $EXTENSAO_VIDEO = ["mp4","webm","ogg"];

    public static $LOG = "### WEE_LOG ### ";


    // Índice 'Tipo' do documento
    public static $DESCRICAO_TIPO_DOCUMENTO = 'Tipo';
    public static $IDENTIFICADOR_TIPO_DOCUMENTO = 'Tipo';


    // Índice 'Status' do documento
    public static $DESCRICAO_STATUS = 'Status';
    public static $IDENTIFICADOR_STATUS = 'status';
    

    // Índice 'Justificativa da Rejeição' do documento
    public static $DESCRICAO_JUSTIFICATIVA = 'Justificativa da Rejeição';
    public static $IDENTIFICADOR_JUSTIFICATIVA = 'justificativa';

    // Propriedades da tabela de log do GED (ações)
    public static $ACAO_GED_INSERIR = "inserir";
    public static $ACAO_GED_ALTERAR = "alterar";


    public static $IDENTIFICADOR_TAMANHO_DOC = 'Tamanho';


    public static $VALOR_DOCUMENTO_APROVADO = "APROVADO";


    public static $VALOR_DOCUMENTO_REJEITADO = "REJEITADO";


    public static $PROCESSOS = [
        'OUTROS', 'FOLHA_PONTO', 'Documentos Diversos'
    ];


    // Arquivo de configurações (.ini)
    public static $INI_KEY_RELATORIOS = 'relatorio';

    public static $INI_KEY_SUBMENUS = 'submenus';

    public static $INI_KEY_CONFIGURACOES = 'configuracoes';

    public static $INI_KEY_NOME_PROCESSO = 'nome';

    public static $INI_KEY_LISTA_TIPOS_DOCUMENTO = 'lista_tipos_documento';

    public static $INI_KEY_LISTA_IDS_AREA = 'lista_areas';

    public static $INI_KEY_FILTRO = 'filtro';

    public static $INI_KEY_USA_VINCULO = 'usa_vinculo';

}