<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('error/api', 'Error::api', ['as' => 'api.error']);

$routes->get('/', 'Home::index', ['as' => 'home']);

// Login
$routes->get('login', 'Login::index', ['as' => 'login']);
$routes->post('login', 'Login::entrar', ['as' => 'login']);
$routes->get('sair', 'Login::sair', ['as' => 'sair']);


// Criar Sessões
$routes->get('sessionInscricaoPFId', 'Sessions::sessionInscricaoPFId', ['as' => 'sessions.inscricaopfid']);


// Controles Pharmakon
$routes->group('pharmakon',  ['namespace' => 'App\Controllers\Pharmakon'], static function ($routes) {
    $routes->get('buscar-pf', 'TblPF::buscar', ['as'=>'pharmakon.pf.buscar'] );
    $routes->get('buscar-pj', 'TblPJ::buscar', ['as'=>'pharmakon.pj.buscar'] );
    $routes->get('buscar-ano-referencia', 'TblTaxaPJ::buscarAnoReferenciaAnuidadePJ', ['as'=>'pharmakon.tblpj.anoreferencia'] );
    $routes->get('buscar-proc-fiscal', 'TblProcessoFiscalPJ::buscarProcessoFiscal', ['as'=>'pharmakon.procfiscal.buscar'] );
    $routes->get('buscar-ano-referencia-pf', 'TblTaxaPF::buscarAnoReferenciaAnuidadePF', ['as'=>'pharmakon.tblpf.anoreferencia'] );
    $routes->get('buscar-proprietarios', 'TblPJPropriedade::buscarProprietarios', ['as'=>'pharmakon.tblpjppropriedade.proprietarios'] );
});
// \Controles Pharmakon

// Administrativo
$routes->group('adm',  ['namespace' => 'App\Controllers\Administrativo'], static function ($routes) {
    $routes->get('/', 'Acl::index', ['as'=>'adm'] );
    
    $routes->get('acl-validar-permissao', 'Acl::validarPermissao', ['as'=>'adm.acl.validarPermissao'] );

    $routes->get('acl', 'Acl::index', ['as'=>'adm.acl'] );
    $routes->get('acl/perfil/(:any)', 'Acl::index/$1', ['as'=>'adm.acl.perfil'] );
    $routes->get('acl/perfil/(:any)/(:any)', 'Acl::index/$1/$2', ['as'=>'adm.acl.tab'] );
    
    $routes->post('acl/criar-perfil', 'Acl::criarPerfil', ['as'=>'adm.acl.criarPerfil'] );
    $routes->post('acl/toggle-permissao-perfil', 'Acl::togglePermissaoAoPerfil', ['as'=>'adm.acl.togglePermissaoAoPerfil'] );
    
    $routes->get('acl/buscar-usuarios', 'Acl::buscarUsuarios', ['as'=>'adm.acl.buscarUsuarios'] );
    $routes->post('acl/vincular-usuarios-perfil', 'Acl::vincularUsuarioPerfil', ['as'=>'adm.acl.vincularUsuarioPerfil'] );
    $routes->post('acl/desvincular-usuarios-perfil', 'Acl::desvincularUsuarioPerfil', ['as'=>'adm.acl.desvincularUsuarioPerfil'] );
});
// \Administrativo



// inscrição e registro
$routes->group('registro',  ['namespace' => 'App\Controllers\Registro'], static function ($routes) {
    $routes->get('/', 'Pf::index', ['as'=>'registro'] );
    
    $routes->get('pf', 'Pf::index', ['as'=>'registro.pf'] );
    $routes->get('pf/(:any)/tab/(:any)', 'Pf::index/$1/$2', ['as'=>'registro.pf.tab'] );

});
// \inscrição e registro


// cobranca
$routes->group('cobranca',  ['namespace' => 'App\Controllers\Cobranca'], static function ($routes) {
    $routes->get('/', 'Pf::index', ['as'=>'cobranca'] );
    
    $routes->get('pf', 'Pf::index', ['as'=>'cobranca.pf'] );
    $routes->get('pf/(:any)/tab/(:any)', 'Pf::index/$1/$2', ['as'=>'cobranca.pf.tab'] );
});
// \cobranca






// PDF
$routes->get('pdf-download/(:any)', 'Pdf::downloadFila/$1', ['as'=>'pdf.downloadfila'] );



// Dashboard
$routes->group('dashboard',  ['namespace' => 'App\Controllers\Dashboard'], static function ($routes) {
    $routes->get('/', 'Dashboard::index', ['as'=>'dashboard'] );
});

// Notificações
$routes->group('notificacoes',  ['namespace' => 'App\Controllers\Notificacoes'], static function ($routes) {
    $routes->get('/', 'PessoaFisica::index', ['as'=>'notificacoes'] );
    

    $routes->get('pf', 'PessoaFisica::index', ['as'=>'notificacoes.pf'] );

    $routes->get('pj', 'PessoaJuridica::index', ['as'=>'notificacoes.pj'] );
    $routes->get('pj/listagem', 'PessoaJuridica::listagem', ['as'=>'notificacoes.pj.listagem'] );
    $routes->get('pj/(:any)', 'PessoaJuridica::index/$1', ['as'=>'notificacoes.pj.editar'] );

    $routes->post('gerar-pdf', 'Notificacao::gerarPDF', ['as'=>'notificacoes.pj.gerarpdf'] );
    $routes->post('gerar-ar', 'Ar::gerarPDF', ['as'=>'notificacoes.pj.gerarar'] );
    $routes->post('gerar-envelope-pardo', 'Envelope::gerarPDFPardo', ['as'=>'notificacoes.pj.gerarenvelopepardo'] );
    $routes->post('gerar-envelope-branco', 'Envelope::gerarPDFBranco', ['as'=>'notificacoes.pj.gerarenvelopebranco'] );
    
    $routes->post('cadastrar', 'Notificacao::cadastrar', ['as'=>'notificacao.cadastrar'] );
    $routes->post('excluir', 'Notificacao::excluir', ['as'=>'notificacoes.excluir']);
    $routes->get('fila', 'Notificacao::fila', ['as'=>'notificacoes.fila'] );

    $routes->post('buscar-qtd-empresas-cadastradas', 'Notificacao::buscarQtdEmpresasCadastradas', ['as'=>'notificacao.buscarqtdempresascadastradas'] );
});

// Cobranças
$routes->group('cobrancas',  ['namespace' => 'App\Controllers\Cobrancas'], static function ($routes) {
    $routes->get('/', 'PessoaFisica::index', ['as'=>'cobrancas'] );

    $routes->get('pf', 'PessoaFisica::index', ['as'=>'cobrancas.pf'] );

    $routes->get('pj', 'PessoaJuridica::index', ['as'=>'cobrancas.pj'] );
    $routes->get('pj/listagem', 'PessoaJuridica::listagem', ['as'=>'cobrancas.pj.listagem'] );
    $routes->get('pj/(:any)', 'PessoaJuridica::index/$1', ['as'=>'cobrancas.pj.editar'] );

    $routes->post('gerar-pdf', 'Oficios::gerarPDF', ['as'=>'cobrancas.pj.gerarpdf'] );
    $routes->post('gerar-ar', 'Ar::gerarPDF', ['as'=>'cobrancas.pj.gerarar'] );
    $routes->post('gerar-envelope-pardo', 'Envelope::gerarPDFPardo', ['as'=>'cobrancas.pj.gerarenvelopepardo'] );
    $routes->post('gerar-envelope-branco', 'Envelope::gerarPDFBranco', ['as'=>'cobrancas.pj.gerarenvelopebranco'] );
    
    $routes->post('cadastrar', 'Oficios::cadastrar', ['as'=>'cobrancas.cadastrar'] );
    $routes->post('excluir', 'Oficios::excluir', ['as'=>'cobrancas.excluir']);
    $routes->get('fila', 'Oficios::fila', ['as'=>'cobrancas.fila'] );

    $routes->post('buscar-qtd-empresas-cadastradas', 'Oficios::buscarQtdEmpresasCadastradas', ['as'=>'cobranca.buscarqtdempresascadastradas'] );
});

// Configurações
$routes->group('adm',  ['namespace' => 'App\Controllers\Configuracoes'], static function ($routes) {
    $routes->get('/', 'Configuracoes::index', ['as'=>'configuracoes'] );
    $routes->get('meu-perfil', 'MeuPerfil::index', ['as'=>'configuracoes.meuperfil'] );
    $routes->post('meu-perfil', 'MeuPerfil::salvar', ['as'=>'configuracoes.meuperfil.salvar'] );
});