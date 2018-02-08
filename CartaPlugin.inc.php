<?php
/**
 * @file plugins/generic/cartaPlugin/cartaPDF.inc.php
 * Héctor Torres - Universidad Autónoma de Nuevo León
 * hector.torresg@uanl.mx
 * Distributed under the GNU GPL v3. For full terms see the file LICENCSE
 *
 * @class cartaPDF
 * @ingroup plugins_generic_cartaPDF
 * @brief Carta PDF Plugin
 */
import('lib.pkp.classes.plugins.GenericPlugin');

class CartaPlugin extends GenericPlugin{

    // Implement template methods from Plugin.
    /**
     * @see Plugin::register()
     */
    function register($category, $path){
        $success = parent::register($category, $path);
        //if(!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return $success;
        if($success && $this->getEnabled()){
            HookRegistry::register('Templates::Article::Footer::PageFooter', array($this, 'callbackTemplateArticlePageFooter'));
            //HookRegistry::register("Templates::Common::Footer::PageFooter", array($this, 'callbackTemplateArticlePageFooter'));
        }
        return $success;
    }

    /**
     * @see Plugin::getName()
     */
    function getName(){
        return __('plugins.generic.cartaPlugin.Name');
    }

    /**
     * @see Plugin::getDisplayName()
     */
    function getDisplayName(){
        return __('plugins.generic.cartaPlugin.displayName');
    }

    /**
     * @see Plugin::getDescription()
     */
    function getDescription(){
        return __('"plugins.generic.cartaPlugin.description');
    }

    /**
     * @copydoc Plugin::getTemplatePath()
     */
    function getTemplatePath($inCore = false){
        return parent::getTemplatePath($inCore) . 'templates/';
    }

<<<<<<< HEAD
=======
    
>>>>>>> 81e83a58a6ee41361583188ece310a919c998101
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
        $url = "crearCarta.php?data=" . $query;
        $smarty->assign('cartaLink', returner);
        $smarty->assign('query', $url);
        $output .= $smarty->fetch($this->getTemplatePath() . 'articleFooter.tpl');
    }
}
?>
