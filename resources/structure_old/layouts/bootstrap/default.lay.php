<?php echo <<<EOF
<!DOCTYPE html>
<!--
    Inicia o documento indicando a linguagem do conteúdo e a direção de leitura
-->
<html lang="pt-br" dir="ltr">
    <head>
        <meta charset="utf-8">

        <!--
        Seta a largura inicial da área do browser, a escala e se aceita zoom.
         - Referência na MDN: https://developer.mozilla.org/pt-BR/docs/Mozilla/Mobile/Viewport_meta_tag
        -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

        <!--
        Otimização para sistema de buscas
         - Referência do Google: https://support.google.com/webmasters/answer/79812?hl=en

            Title:          Título da página. É importante manter número de
                            caracteres até no máximo 63.
            Description:    Descrição do conteúdo da página, um resumo.
                            Deve conter até 153 caracteres.
            Keywords:       Palavras chaves relacionadas com o conteúdo da
                            página, é importante que algumas delas estejam em
                            títulos e tenham relevância no texto.
            Rating:         Classificação do conteúdo, por exemplo, proibído
                            para menores.
            Robots:         Controle sobre a indexação dos motores de busca.
            Author:         Nome do autor da página. Ao associar com uma página
                            do Google+, o Google irá adicionar um vinculo nos
                            resultados.
                            https://developers.google.com/structured-data/?rd=1
            Me:             Mesmo funcionamento de Author porem no padrão XFN
                            http://gmpg.org/xfn/
        -->
        <title><?php echo \$this->title ?></title>
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="rating" content="general" />
        <meta name="robots" content="ALL" />
        <meta name="author" content="">
        <link rel="me" href="" />


        <!--
        Otimização para compartilhamento em redes sociais
        Trate esse dados para cada tipo de conteúdo ou página
         - Link de referência: http://ogp.me/
         - Link para tutorial: http://tableless.com.br/utilizando-meta-tags-facebook
         - Link de referências do Facebook: https://developers.facebook.com/docs/sharing/webmasters
         - Link de referências do Google: https://developers.google.com/+/web/snippet/#frequently-asked-questions
         - Link para referência de meta tags : https://developer.mozilla.org/pt-PT/docs/utilizando_meta_tags

            og:site_name        Nome do site
            og:url              URL para a página
            og:type             Tipo do documento
            og:locale           Linguagem do documento
            og:title            Título ao compartilhar
            og:description      Descrição que irá aparecer ao ser compartilhado
            og:image            Imagem que irá aparecer junto ao link compartilhado
        -->
        <meta property="og:site_name" content="">
        <meta property="og:url" content="">
        <meta property="og:type" content="website">
        <meta property="og:locale" content="pt_BR">
        <meta property="og:title" content="">
        <meta property="og:description" content="">
        <meta property="og:image" content="">


        <!--
        Twitter Cards
        Otimização para compartilhamento no twitter.
         - Link de referências: https://dev.twitter.com/cards/overview
        -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="">
        <meta name="twitter:creator" content="">
        <meta name="twitter:text:title" content="">
        <meta name="twitter:title" content="">
        <meta name="twitter:description" content="">
        <meta property="twitter:image" content="">


        <!--
        Favicons
         - Link de referência: http://tableless.com.br/favicons/
         - Gerador de favicons: http://www.favicon-generator.org/
        -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/favicon-16x16.png">
        <link rel="shortcut icon" type="image/png" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/favicon-16x16.png">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/favicon.ico">
        <link rel="manifest" href="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo \$this->_app->getAppBaseUrl() ?>public/images/favicons/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">



        <!--
        Adicionando links alternativos
        Indica endereços de páginas com o mesmo conteúdo com formatos ou línguas
        diferentes.
         - Link de referência: https://support.google.com/webmasters/answer/189077?hl=pt-br
         - Link de referência: https://support.google.com/webmasters/answer/1663744?hl=pt-br
         - Link de referência: https://webmasters.googleblog.com/2011/09/pagination-with-relnext-and-relprev.html
         - Link de referência: https://developer.mozilla.org/en-US/docs/Web/HTML/Link_types
        -->
        <!--
        <link rel="canonical" href="http://www.marcusmaia.com.br/blog/article/example" >
        <link rel="index" href="http://www.marcusmaia.com.br/blog/article/example-index" />
        <link rel="first" href="http://www.marcusmaia.com.br/blog/article/example-first" />
        <link rel="last" href="http://www.marcusmaia.com.br/blog/article/example-last" />
        <link rel="prev" href="http://www.marcusmaia.com.br/blog/article/example-prev" />
        <link rel="next" href="http://www.marcusmaia.com.br/blog/article/example-next" />
        <link rel="alternate" type="application/json" href="/json/blog/article/example">
        <link rel="alternate" type="application/rss+xml" href="/rss/blog/article/example">
        <link rel="alternate" type="application/atom+xml" href="/atom/blog/article/example">
        <link rel="alternate" hreflang="en" href="http://www.marcusmaia.com.br/en/blog/article/example" title="Título do artigo em inglês">
        <link rel="alternate" hreflang="fr" href="http://www.marcusmaia.com.br/fr//blog/article/example" title="Título do artigo em francês">
        <link rel="alternate" hreflang="it" href="http://www.marcusmaia.com.br/it/blog/article/example" title="Título do artigo em italiano">
        -->

        <?php
            \$this->addCSS('components/bootstrap.min.css');
            \$this->addCSS('components/bootstrap-theme.min.css');
            \$this->addCss('components/font-awesome.min.css');
            \$this->addCss('components/grid.css');
            \$this->addCss('components/treegrid.css');
            \$this->addCss('components/treelist.css');
            \$this->addCss('components/checkboxlist.css');
            \$this->addCss('components/cropbox.css');
            \$this->addCss('components/datepicker3.css');
            \$this->addCss('components/summernote.css');
            \$this->addCss('components/jquery.custom.inputfile.css');
            \$this->addCss('components/framework.css');
            \$this->addCss('layout/general.css');
            echo \$this->getCss();
        ?>
    </head>

    <body>
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo UrlMaker::toAction( 'index' ) ?>"><?php echo \$this->_app->getAppName() ?></a>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="col-md-3">
                <ul class="nav nav-pills nav-stacked">

EOF;

foreach ( $modules as $module ) {
	$moduleName = Text::humanize( $module );
	echo "\t\t\t\t\t\t<li><a href=\"<?php echo UrlMaker::toAction( '$module' ) ?>\">$moduleName</a>\n";
}

echo <<<EOF
                </ul>
            </div>

            <div class="col-md-9">

                <?php echo \$this->content; ?>

            </div>
        </div>

        <div id="footer">
            <div class="container">
                <p class="text-muted"><?php echo \$this->_app->getAppName() ?> v<?php echo \$this->_app->getAppVersion() ?> &copy; All rights reserved</p>
            </div>
        </div>

        <?php
            \$this->addJs('components/jquery.js');
            \$this->addJs('components/jquery.cookie.js');
            \$this->addJs('components/jquery.form.js');
            \$this->addJs('components/jquery.mask.js');
            \$this->addJs('components/jquery.maskmoney.js');
            \$this->addJs('components/jquery.validate.js');
            \$this->addJs('components/jquery.validate.pt_br.js');
            \$this->addJs('components/jquery.validate.additional.js');
            \$this->addJs('components/jquery.modalwindow.js');
            \$this->addJs('components/jquery.cropbox.js');
            \$this->addJs('components/jquery.treegrid.js');
            \$this->addJs('components/jquery.treegrid.bootstrap3.js');
            \$this->addJs('components/jquery.custom.fileinput.js');
            \$this->addJs('components/jquery.sharebutton.js');
            \$this->addJs('components/bootstrap.min.js');
            \$this->addJs('components/bootstrap.bootbox.min.js');
            \$this->addJs('components/bootstrap.datepicker.min.js');
            \$this->addJs('components/bootstrap.datepicker.pt_br.min.js');
            \$this->addJs('components/summernote.min.js');
            \$this->addJs('components/summernote.pt_br.js');
            \$this->addJs('components/grid.js');
            \$this->addJs('components/framework.js');
            echo \$this->getJs();
        ?>
    </body>
</html>
EOF;
?>