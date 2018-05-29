<?php
/**
 * @file plugins/generic/cartaPlugin/cartaPDF.inc.php
 * Héctor Torres - Universidad Autónoma de Nuevo León
 * hector.torresg@uanl.mx
 * Distributed under the GNU GPL v3. For full terms see the file LICENCSE
 *
 * @class CartaPlugin
 * @ingroup plugins_generic_cartaPlugin
 * @brief Carta Plugin
 */

import('lib.pkp.classes.plugins.GenericPlugin');

class CartaPlugin extends GenericPlugin{

    // Implement template methods from Plugin.
    function register($category, $path){
        $success = parent::register($category, $path);
        //if(!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return $success;
        if($success && $this->getEnabled()){
	    HookRegistry::register('Templates::Article::Footer::PageFooter', array($this, 'callbackTemplateArticlePageFooter'));
            HookRegistry::register('TemplateManager::display', array($this, 'displayCallback'));
        }
        return $success;
    }

    function getName(){
        return __('plugins.generic.carta.Name');
    }

    function getDisplayName(){
        return __('plugins.generic.carta.displayName');
    }

    function getDescription(){
        return __('plugins.generic.carta.description');
    }

    function getTemplatePath($inCore = false){
        return parent::getTemplatePath($inCore) . 'templates/';
    }

    function getEnabled($contextId = null){
        if(!Config::getVar('general', 'installed')) return true;
        return parent::getEnabled($contextId);
    }

    // View level hook implementations.
    /**
     * @see templates/article/footer.tpl
     */
    function callbackTemplateArticlePageFooter($hookName, $params){
        $smarty =& $params[1];
        $output =& $params[2];
        $displayedArticle = $smarty->get_template_vars('article');

        // Get Values to use in the Letter
        $authors = $displayedArticle->getAuthors();
        $titulo = $displayedArticle->getTitle();
        $status = $displayedArticle->getStatus();
        $fechaSubmit = $displayedArticle->getDateSubmited();
        $fechaMod = $displayedArticle->getDateStatusModified();
        $authorDao = DAORegistry::getDAO('AuthorDAO');

        $nombres = [];
        foreach ($authors as $author) {
            $nombres[] = $author->getFullName();
        }

        $resultado = array(
            'titulo'=>$title,
            'autores'=>$nombres,
            'fechaSubmit' => $fechaSubmit,
            'fechaAceptada' => $fechaMod,
            'status'=>$status
        );

        // Visualizar
        $query = base64_decode( json_encode( $resultado ) );
        $returner = "<a href='crearCarta.php?data=" . $query . "' target='_blank' class='pkp_button_primary'> Ver Carta de Aceptación </a>";
        $smarty->assign('query', $returner);
        $output .= $smarty->fetch($this->getTemplatePath() . 'articleFooter.tpl');
    }

    function insertFooter($hookName, $params){
        $smarty =& $params[1];
        $output =& $params[2];
        $templateMgr =& TemplateManager::getManager();

		$journal = $templateMgr->get_template_vars('currentJournal');
		$issue = $templateMgr->get_template_vars('issue');
        $article = $templateMgr->get_template_vars('article');

        $authors = $article->getAuthors();
        $nombres = [];
        foreach ($authors as $author) {
            $nombres[] = $author->getFullName();
        }
        $titulo = $article->getTitle();
        $status = $article->getStatus();
        $fechaPublicacion = $article->getDatePublished();
        if(!$fechaPublicacion){
            $fechaPublicacion = $issue->getDatePublished();
        }

        $result[] = array('titulo', $titulo);
        $result[] = array('autores', $nombres);
        if($fechaPublicacion){
            $result[] = array('fechaPublicacion', date('Y-m-d', strtotime($fechaPublicacion)));
        }
        $result[] = array('status', $nombres);

    }
}
?>
