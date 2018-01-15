{**
 * plugins/generic/cartaPlugin/templates/articleFooter.tpl
 * Héctor Torres - Universidad Autónoma de Nuevo León
 * hector.torresg@uanl.mx
 * Distributed under the GNU GPL v3. For full terms see the file LICENCSE
 *
 * Template para ser incluido vía Templates::Article::Footer::PageFooter hook.
 *}

 <div id="cartaPdf">
     <h3>{translate key="plugins.generic.cartaPDF.header"}</h3>
     <div class="">
        <ul>
            <li>
                {$returner}
            </li>
            <li>
                <a href="{$query}" target='_blank' class='pkp_button_primary'> Ver Carta de Aceptación </a>
            </li>
        </ul>
     <div>
 </div>
