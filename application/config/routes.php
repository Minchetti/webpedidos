<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'autenticacao';
$route['principal'] = 'dashboard/dashboard';

/**
 *  Autenticacao
 */
$route['logout'] = 'autenticacao/logout';
$route['esqueci_senha'] = 'autenticacao/esquecisenha';
$route['recuperasenha/(:any)/(:any)/(:any)'] = 'autenticacao/recuperandosenha/$1/$2/$3';

/**
 *  Pedido / Requisições
 */
$route['requisicao'] = 'pedido/requisicao';
$route['localizar_requisicao'] = 'pedido/requisicao/localizar';
$route['aprovar_requisicoes'] = 'pedido/requisicao/listarpendentes';
$route['listar_solicitacoes'] = 'pedido/requisicao/listarpendentes';
 

/**
 * Pedido / Templates
 */
$route['template'] = 'pedido/template';
$route['template_nova'] = 'pedido/template/template_nova';
$route['atualizar_template/(:num)'] = 'pedido/template/atualizar_template/$1';

/*
 * Relatórios
 */
$route['relatorios'] = 'relatorio/relatorio';

/**
 *  Sugestões
 */
 $route['sugestoes'] = 'sugestoes/sugestao';


/**
 *  Usuário
 */

$route['perfil'] = 'usuario/usuario/alterardados';
$route['usuario'] = 'usuario/usuario/index';



/**
 *  Grupos de Acesso
 */

$route['grupoacesso'] = 'grupoacesso/grupoacesso/index';



$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



$route['recebimento'] = 'recebimento/recebimento/index';
$route['painel_recebimento'] = 'recebimento/recebimento/painel_recebimento';
$route['recebe'] = 'recebimento/recebe';



