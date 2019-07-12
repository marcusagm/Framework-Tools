<div class="row">
    <div class="col-md-3">
        <?php $this->addPartial( 'menu', 'projects', array('active' => 'config', 'record' => $this->record ) ) ?>
    </div>
    <div class="col-md-9">
        <h1><span class="ftools-cogs"></span> Configurations</h1>
        <?php if( $this->message ) { ?>
            <div class="alert alert-warning"><?php echo $this->message ?></div>
        <?php } ?>
        <form class="form-horizontal" method="post" action="<?php echo UrlMaker::toAction( 'config', 'save' ) ?>">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php if( $this->record ) { ?>
                        Editing configuration files for: <?php echo $this->record->getName() ?>
                    <?php } else { ?>
                        Create the configuration file
                    <?php } ?>
                </div>
                <div class="panel-body">
                    <fieldset>
                        <legend>Details</legend>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="project_version">Version</label>
                            <div class="col-md-8">
                                <input id="project_version" name="project_version" value="<?php echo $this->record ? $this->record->getVersion() : '' ?>" placeholder="1.0" class="form-control input-md" required pattern="[0-9\.]+" title="Number or dot." type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="project_language">Default language</label>
                            <div class="col-md-8">
                                <select id="project_language" name="project_language" class="form-control">
                                    <?php $language = $this->record ? $this->record->getLanguage() : false ?>
                                    <option<?php echo $language && $language == 'pt-br' ? ' selected' : '' ?> value="pt-br">Portuguese (Brazil)</option>
                                    <option<?php echo $language && $language == 'af' ? ' selected' : '' ?> value="af">Afrikaans</option>
                                    <option<?php echo $language && $language == 'sq' ? ' selected' : '' ?> value="sq">Albanian</option>
                                    <option<?php echo $language && $language == 'ar-dz' ? ' selected' : '' ?> value="ar-dz">Arabic (Algeria)</option>
                                    <option<?php echo $language && $language == 'ar-bh' ? ' selected' : '' ?> value="ar-bh">Arabic (Bahrain)</option>
                                    <option<?php echo $language && $language == 'ar-eq' ? ' selected' : '' ?> value="ar-eg">Arabic (Egypt)</option>
                                    <option<?php echo $language && $language == 'ar-iq' ? ' selected' : '' ?> value="ar-iq">Arabic (Iraq)</option>
                                    <option<?php echo $language && $language == 'ar-jo' ? ' selected' : '' ?> value="ar-jo">Arabic (Jordan)</option>
                                    <option<?php echo $language && $language == 'ar-kw' ? ' selected' : '' ?> value="ar-kw">Arabic (Kuwait)</option>
                                    <option<?php echo $language && $language == 'ar-lb' ? ' selected' : '' ?> value="ar-lb">Arabic (Lebanon)</option>
                                    <option<?php echo $language && $language == 'ar-ly' ? ' selected' : '' ?> value="ar-ly">Arabic (libya)</option>
                                    <option<?php echo $language && $language == 'ar-ma' ? ' selected' : '' ?> value="ar-ma">Arabic (Morocco)</option>
                                    <option<?php echo $language && $language == 'ar-om' ? ' selected' : '' ?> value="ar-om">Arabic (Oman)</option>
                                    <option<?php echo $language && $language == 'ar-qa' ? ' selected' : '' ?> value="ar-qa">Arabic (Qatar)</option>
                                    <option<?php echo $language && $language == 'ar-sa' ? ' selected' : '' ?> value="ar-sa">Arabic (Saudi Arabia)</option>
                                    <option<?php echo $language && $language == 'ar-sy' ? ' selected' : '' ?> value="ar-sy">Arabic (Syria)</option>
                                    <option<?php echo $language && $language == 'ar-tn' ? ' selected' : '' ?> value="ar-tn">Arabic (Tunisia)</option>
                                    <option<?php echo $language && $language == 'ar-ae' ? ' selected' : '' ?> value="ar-ae">Arabic (U.A.E.)</option>
                                    <option<?php echo $language && $language == 'ar-ye' ? ' selected' : '' ?> value="ar-ye">Arabic (Yemen)</option>
                                    <option<?php echo $language && $language == 'ar' ? ' selected' : '' ?> value="ar">Arabic</option>
                                    <option<?php echo $language && $language == 'hy' ? ' selected' : '' ?> value="hy">Armenian</option>
                                    <option<?php echo $language && $language == 'as' ? ' selected' : '' ?> value="as">Assamese</option>
                                    <option<?php echo $language && $language == 'az' ? ' selected' : '' ?> value="az">Azeri (Cyrillic)</option>
                                    <option<?php echo $language && $language == 'az' ? ' selected' : '' ?> value="az">Azeri (Latin)</option>
                                    <option<?php echo $language && $language == 'eu' ? ' selected' : '' ?> value="eu">Basque</option>
                                    <option<?php echo $language && $language == 'be' ? ' selected' : '' ?> value="be">Belarusian</option>
                                    <option<?php echo $language && $language == 'bn' ? ' selected' : '' ?> value="bn">Bengali</option>
                                    <option<?php echo $language && $language == 'bg' ? ' selected' : '' ?> value="bg">Bulgarian</option>
                                    <option<?php echo $language && $language == 'ca' ? ' selected' : '' ?> value="ca">Catalan</option>
                                    <option<?php echo $language && $language == 'zh-cn' ? ' selected' : '' ?> value="zh-cn">Chinese (China)</option>
                                    <option<?php echo $language && $language == 'zh-hk' ? ' selected' : '' ?> value="zh-hk">Chinese (Hong Kong SAR)</option>
                                    <option<?php echo $language && $language == 'zh-mo' ? ' selected' : '' ?> value="zh-mo">Chinese (Macau SAR)</option>
                                    <option<?php echo $language && $language == 'zh-sg' ? ' selected' : '' ?> value="zh-sg">Chinese (Singapore)</option>
                                    <option<?php echo $language && $language == 'zh-tw' ? ' selected' : '' ?> value="zh-tw">Chinese (Taiwan)</option>
                                    <option<?php echo $language && $language == 'zh' ? ' selected' : '' ?> value="zh">Chinese</option>
                                    <option<?php echo $language && $language == 'hr' ? ' selected' : '' ?> value="hr">Croatian</option>
                                    <option<?php echo $language && $language == 'cs' ? ' selected' : '' ?> value="cs">Chech</option>
                                    <option<?php echo $language && $language == 'da' ? ' selected' : '' ?> value="da">Danish</option>
                                    <option<?php echo $language && $language == 'div' ? ' selected' : '' ?> value="div">Divehi</option>
                                    <option<?php echo $language && $language == 'nl-be' ? ' selected' : '' ?> value="nl-be">Dutch (Belgium)</option>
                                    <option<?php echo $language && $language == 'nl' ? ' selected' : '' ?> value="nl">Dutch (Netherlands)</option>
                                    <option<?php echo $language && $language == 'en-au' ? ' selected' : '' ?> value="en-au">English (Australia)</option>
                                    <option<?php echo $language && $language == 'en-bz' ? ' selected' : '' ?> value="en-bz">English (Belize)</option>
                                    <option<?php echo $language && $language == 'en-ca' ? ' selected' : '' ?> value="en-ca">English (Canada)</option>
                                    <option<?php echo $language && $language == 'en' ? ' selected' : '' ?> value="en">English (Caribbean)</option>
                                    <option<?php echo $language && $language == 'en-ie' ? ' selected' : '' ?> value="en-ie">English (Ireland)</option>
                                    <option<?php echo $language && $language == 'en-jm' ? ' selected' : '' ?> value="en-jm">English (Jamaica)</option>
                                    <option<?php echo $language && $language == 'en-nz' ? ' selected' : '' ?> value="en-nz">English (New Zealand)</option>
                                    <option<?php echo $language && $language == 'en-ph' ? ' selected' : '' ?> value="en-ph">English (Philippines)</option>
                                    <option<?php echo $language && $language == 'en-za' ? ' selected' : '' ?> value="en-za">English (South Africa)</option>
                                    <option<?php echo $language && $language == 'en-tt' ? ' selected' : '' ?> value="en-tt">English (Trinidad)</option>
                                    <option<?php echo $language && $language == 'en-gb' ? ' selected' : '' ?> value="en-gb">English (United Kingdom)</option>
                                    <option<?php echo $language && $language == 'en-us' ? ' selected' : '' ?> value="en-us">English (United States)</option>
                                    <option<?php echo $language && $language == 'en-zw' ? ' selected' : '' ?> value="en-zw">English (Zimbabwe)</option>
                                    <option<?php echo $language && $language == 'en' ? ' selected' : '' ?> value="en">English</option>
                                    <option<?php echo $language && $language == 'et' ? ' selected' : '' ?> value="et">Estonian</option>
                                    <option<?php echo $language && $language == 'fo' ? ' selected' : '' ?> value="fo">Faeroese</option>
                                    <option<?php echo $language && $language == 'fa' ? ' selected' : '' ?> value="fa">Farsi</option>
                                    <option<?php echo $language && $language == 'fi' ? ' selected' : '' ?> value="fi">Finnish</option>
                                    <option<?php echo $language && $language == 'fr-be' ? ' selected' : '' ?> value="fr-be">French (Belgium)</option>
                                    <option<?php echo $language && $language == 'fr-ca' ? ' selected' : '' ?> value="fr-ca">French (Canada)</option>
                                    <option<?php echo $language && $language == 'fr' ? ' selected' : '' ?> value="fr">French (France)</option>
                                    <option<?php echo $language && $language == 'fr-lu' ? ' selected' : '' ?> value="fr-lu">French (Luxembourg)</option>
                                    <option<?php echo $language && $language == 'fr-mc' ? ' selected' : '' ?> value="fr-mc">French (Monaco)</option>
                                    <option<?php echo $language && $language == 'fr-ch' ? ' selected' : '' ?> value="fr-ch">French (Switzerland)</option>
                                    <option<?php echo $language && $language == 'mk' ? ' selected' : '' ?> value="mk">FYRO Macedonian</option>
                                    <option<?php echo $language && $language == 'gd' ? ' selected' : '' ?> value="gd">Gaelic</option>
                                    <option<?php echo $language && $language == 'ka' ? ' selected' : '' ?> value="ka">Georgian</option>
                                    <option<?php echo $language && $language == 'de-at' ? ' selected' : '' ?> value="de-at">German (Austria)</option>
                                    <option<?php echo $language && $language == 'de' ? ' selected' : '' ?> value="de">German (Germany)</option>
                                    <option<?php echo $language && $language == 'de-li' ? ' selected' : '' ?> value="de-li">German (Liechtenstein)</option>
                                    <option<?php echo $language && $language == 'de-lu' ? ' selected' : '' ?> value="de-lu">German (lexumbourg)</option>
                                    <option<?php echo $language && $language == 'de-ch' ? ' selected' : '' ?> value="de-ch">German (Switzerland)</option>
                                    <option<?php echo $language && $language == 'el' ? ' selected' : '' ?> value="el">Greek</option>
                                    <option<?php echo $language && $language == 'gu' ? ' selected' : '' ?> value="gu">Gujarati</option>
                                    <option<?php echo $language && $language == 'he' ? ' selected' : '' ?> value="he">Hebrew</option>
                                    <option<?php echo $language && $language == 'hi' ? ' selected' : '' ?> value="hi">Hindi</option>
                                    <option<?php echo $language && $language == 'hu' ? ' selected' : '' ?> value="hu">Hungarian</option>
                                    <option<?php echo $language && $language == 'is' ? ' selected' : '' ?> value="is">Icelandic</option>
                                    <option<?php echo $language && $language == 'id' ? ' selected' : '' ?> value="id">Indonesian</option>
                                    <option<?php echo $language && $language == 'it' ? ' selected' : '' ?> value="it">Italian (Italy)</option>
                                    <option<?php echo $language && $language == 'it-ch' ? ' selected' : '' ?> value="it-ch">Italian (Switzerland)</option>
                                    <option<?php echo $language && $language == 'ja' ? ' selected' : '' ?> value="ja">Japanese</option>
                                    <option<?php echo $language && $language == 'kn' ? ' selected' : '' ?> value="kn">Kannada</option>
                                    <option<?php echo $language && $language == 'kk' ? ' selected' : '' ?> value="kk">Kazakh</option>
                                    <option<?php echo $language && $language == 'kok' ? ' selected' : '' ?> value="kok">Konkani</option>
                                    <option<?php echo $language && $language == 'ko' ? ' selected' : '' ?> value="ko">Korean</option>
                                    <option<?php echo $language && $language == 'kz' ? ' selected' : '' ?> value="kz">Kyrgyz</option>
                                    <option<?php echo $language && $language == 'lv' ? ' selected' : '' ?> value="lv">Latvian</option>
                                    <option<?php echo $language && $language == 'lt' ? ' selected' : '' ?> value="lt">Lithuanian</option>
                                    <option<?php echo $language && $language == 'ms' ? ' selected' : '' ?> value="ms">Malay (Brunei)</option>
                                    <option<?php echo $language && $language == 'ms' ? ' selected' : '' ?> value="ms">Malay (Malaysia)</option>
                                    <option<?php echo $language && $language == 'ml' ? ' selected' : '' ?> value="ml">Malayalam</option>
                                    <option<?php echo $language && $language == 'mt' ? ' selected' : '' ?> value="mt">Maltese</option>
                                    <option<?php echo $language && $language == 'mr' ? ' selected' : '' ?> value="mr">Marathi</option>
                                    <option<?php echo $language && $language == 'mn' ? ' selected' : '' ?> value="mn">Mongolian (Cyrillic)</option>
                                    <option<?php echo $language && $language == 'ne' ? ' selected' : '' ?> value="ne">Nepali (India)</option>
                                    <option<?php echo $language && $language == 'nb-no' ? ' selected' : '' ?> value="nb-no">Norwegian (Bokmal)</option>
                                    <option<?php echo $language && $language == 'no' ? ' selected' : '' ?> value="no">Norwegian (Bokmal)</option>
                                    <option<?php echo $language && $language == 'nn-no' ? ' selected' : '' ?> value="nn-no">Norwegian (Nynorsk)</option>
                                    <option<?php echo $language && $language == 'or' ? ' selected' : '' ?> value="or">Oriya</option>
                                    <option<?php echo $language && $language == 'pl' ? ' selected' : '' ?> value="pl">Polish</option>
                                    <option<?php echo $language && $language == 'pt-br' ? ' selected' : '' ?> value="pt-br">Portuguese (Brazil)</option>
                                    <option<?php echo $language && $language == 'pt' ? ' selected' : '' ?> value="pt">Portuguese (Portugal)</option>
                                    <option<?php echo $language && $language == 'pa' ? ' selected' : '' ?> value="pa">Punjabi</option>
                                    <option<?php echo $language && $language == 'rm' ? ' selected' : '' ?> value="rm">Rhaeto-Romanic</option>
                                    <option<?php echo $language && $language == 'ro-md' ? ' selected' : '' ?> value="ro-md">Romanian (Moldova)</option>
                                    <option<?php echo $language && $language == 'ro' ? ' selected' : '' ?> value="ro">Romanian</option>
                                    <option<?php echo $language && $language == 'ru-md' ? ' selected' : '' ?> value="ru-md">Russian (Moldova)</option>
                                    <option<?php echo $language && $language == 'ru' ? ' selected' : '' ?> value="ru">Russian</option>
                                    <option<?php echo $language && $language == 'sa' ? ' selected' : '' ?> value="sa">Sanskrit</option>
                                    <option<?php echo $language && $language == 'sr' ? ' selected' : '' ?> value="sr">Serbian (Cyrillic)</option>
                                    <option<?php echo $language && $language == 'sr' ? ' selected' : '' ?> value="sr">Serbian (Latin)</option>
                                    <option<?php echo $language && $language == 'sk' ? ' selected' : '' ?> value="sk">Slovak</option>
                                    <option<?php echo $language && $language == 'ls' ? ' selected' : '' ?> value="ls">Slovenian</option>
                                    <option<?php echo $language && $language == 'sb' ? ' selected' : '' ?> value="sb">Sorbian</option>
                                    <option<?php echo $language && $language == 'es-ar' ? ' selected' : '' ?> value="es-ar">Spanish (Argentina)</option>
                                    <option<?php echo $language && $language == 'es-bo' ? ' selected' : '' ?> value="es-bo">Spanish (Bolivia)</option>
                                    <option<?php echo $language && $language == 'es-cl' ? ' selected' : '' ?> value="es-cl">Spanish (Chile)</option>
                                    <option<?php echo $language && $language == 'es-co' ? ' selected' : '' ?> value="es-co">Spanish (Colombia)</option>
                                    <option<?php echo $language && $language == 'es-cr' ? ' selected' : '' ?> value="es-cr">Spanish (Costa Rica)</option>
                                    <option<?php echo $language && $language == 'es-do' ? ' selected' : '' ?> value="es-do">Spanish (Dominican Republic)</option>
                                    <option<?php echo $language && $language == 'es-ec' ? ' selected' : '' ?> value="es-ec">Spanish (Ecuador)</option>
                                    <option<?php echo $language && $language == 'es-sv' ? ' selected' : '' ?> value="es-sv">Spanish (El Salvador)</option>
                                    <option<?php echo $language && $language == 'es-gt' ? ' selected' : '' ?> value="es-gt">Spanish (Guatemala)</option>
                                    <option<?php echo $language && $language == 'es-hn' ? ' selected' : '' ?> value="es-hn">Spanish (Honduras)</option>
                                    <option<?php echo $language && $language == 'es' ? ' selected' : '' ?> value="es">Spanish (International Sort)</option>
                                    <option<?php echo $language && $language == 'es-mx' ? ' selected' : '' ?> value="es-mx">Spanish (Mexico)</option>
                                    <option<?php echo $language && $language == 'es-ni' ? ' selected' : '' ?> value="es-ni">Spanish (Nicaragua)</option>
                                    <option<?php echo $language && $language == 'es-pa' ? ' selected' : '' ?> value="es-pa">Spanish (Panama)</option>
                                    <option<?php echo $language && $language == 'es-py' ? ' selected' : '' ?> value="es-py">Spanish (Paraguay)</option>
                                    <option<?php echo $language && $language == 'es-pe' ? ' selected' : '' ?> value="es-pe">Spanish (Peru)</option>
                                    <option<?php echo $language && $language == 'es-pr' ? ' selected' : '' ?> value="es-pr">Spanish (Puerto Rico)</option>
                                    <option<?php echo $language && $language == 'es' ? ' selected' : '' ?> value="es">Spanish (Traditional Sort)</option>
                                    <option<?php echo $language && $language == 'es-us' ? ' selected' : '' ?> value="es-us">Spanish (United States)</option>
                                    <option<?php echo $language && $language == 'es-uy' ? ' selected' : '' ?> value="es-uy">Spanish (Uruguay)</option>
                                    <option<?php echo $language && $language == 'es-ve' ? ' selected' : '' ?> value="es-ve">Spanish (Venezuela)</option>
                                    <option<?php echo $language && $language == 'sx' ? ' selected' : '' ?> value="sx">Sutu</option>
                                    <option<?php echo $language && $language == 'sw' ? ' selected' : '' ?> value="sw">Swahili</option>
                                    <option<?php echo $language && $language == 'sv-fi' ? ' selected' : '' ?> value="sv-fi">Swedish (Finland)</option>
                                    <option<?php echo $language && $language == 'sv' ? ' selected' : '' ?> value="sv">Swedish</option>
                                    <option<?php echo $language && $language == 'syr' ? ' selected' : '' ?> value="syr">Syriac</option>
                                    <option<?php echo $language && $language == 'ta' ? ' selected' : '' ?> value="ta">Tamil</option>
                                    <option<?php echo $language && $language == 'tt' ? ' selected' : '' ?> value="tt">Tatar</option>
                                    <option<?php echo $language && $language == 'te' ? ' selected' : '' ?> value="te">Telugu</option>
                                    <option<?php echo $language && $language == 'th' ? ' selected' : '' ?> value="th">Thai</option>
                                    <option<?php echo $language && $language == 'ts' ? ' selected' : '' ?> value="ts">Tsonga</option>
                                    <option<?php echo $language && $language == 'tn' ? ' selected' : '' ?> value="tn">Tswana</option>
                                    <option<?php echo $language && $language == 'tr' ? ' selected' : '' ?> value="tr">Turkish</option>
                                    <option<?php echo $language && $language == 'uk' ? ' selected' : '' ?> value="uk">Ukrainian</option>
                                    <option<?php echo $language && $language == 'ur' ? ' selected' : '' ?> value="ur">Urdu</option>
                                    <option<?php echo $language && $language == 'uz' ? ' selected' : '' ?> value="uz">Uzbek (Cyrillic)</option>
                                    <option<?php echo $language && $language == 'uz' ? ' selected' : '' ?> value="uz">Uzbek (Latin)</option>
                                    <option<?php echo $language && $language == 'vi' ? ' selected' : '' ?> value="vi">Vietnamese</option>
                                    <option<?php echo $language && $language == 'xh' ? ' selected' : '' ?> value="xh">Xhosa</option>
                                    <option<?php echo $language && $language == 'yi' ? ' selected' : '' ?> value="yi">Yiddish</option>
                                    <option<?php echo $language && $language == 'zu' ? ' selected' : '' ?> value="zu">Zulu</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="project_charset">Default charset</label>
                            <div class="col-md-8">
                                <select id="project_charset" name="project_charset" class="form-control">
                                    <option value="utf-8" selected>UTF-8</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Routes</legend>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="project_url">URL base</label>
                            <div class="col-md-8">
                                <input id="project_url" name="project_url" value="<?php echo $this->record ? $this->record->getBaseUrl() : '' ?>" placeholder="http://localhost/project/" class="form-control input-md" required type="url">
                                <span class="help-block">Add slash at the end of url.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="project_module_index">Main module</label>
                            <div class="col-md-8">
                                <input id="project_module_index" name="project_module_index" value="<?php echo $this->record ? $this->record->getModuleIndex() : '' ?>" placeholder="index" class="form-control input-md" type="text" pattern="[a-z]+" title="Do not use spaces or symbols.">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Environment</legend>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="project_environment">Environment</label>
                            <div class="col-md-8">
                                <select id="project_environment" name="project_environment" class="form-control">
                                    <?php $environment = $this->record ? $this->record->getEnvironment() : false ?>
                                    <option<?php echo $environment && $environment == 'development' ? ' selected' : '' ?> value="development">Development</option>
                                    <option<?php echo $environment && $environment == 'testing' ? ' selected' : '' ?> value="testing">Testing</option>
                                    <option<?php echo $environment && $environment == 'qa' ? ' selected' : '' ?> value="qa">Q&amp;A</option>
                                    <option<?php echo $environment && $environment == 'production' ? ' selected' : '' ?> value="production">Production</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="project_debug">Debug</label>
                            <div class="col-md-8">
                                <select id="project_debug" name="project_debug" class="form-control">
                                    <?php $debug = $this->record ? $this->record->getDebug() : false ?>
                                    <option<?php echo $debug && $debug == '0' ? ' selected' : '' ?> value="0">Disabled</option>
                                    <option<?php echo $debug && $debug == '1' ? ' selected' : '' ?> value="1" selected>Screen</option>
                                    <option<?php echo $debug && $debug == '2' ? ' selected' : '' ?> value="2">Firebug</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="project_report">Report log</label>
                            <div class="col-md-8">
                                <select id="project_report" name="project_report" class="form-control">
                                    <?php $report = $this->record ? $this->record->getReport() : false ?>
                                    <option<?php echo $report && $report == '0' ? ' selected' : '' ?> value="0" selected>Save on server</option>
                                    <option<?php echo $report && $report == '1' ? ' selected' : '' ?> value="1">Send mail</option>
                                    <option<?php echo $report && $report == '2' ? ' selected' : '' ?> value="2">Save on server and send mail</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="project_report_subject">Subject of the email report</label>
                            <div class="col-md-8">
                                <input id="project_report_subject" name="project_report_subject" placeholder="Error report" class="form-control input-md" required type="text" value="<?php echo $this->record ? $this->record->getReportEmailSubject() : '' ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="project_report_mail">Send report to</label>
                            <div class="col-md-8">
                                <input id="project_report_mail" name="project_report_mail" placeholder="error@domain.com" class="form-control input-md" required type="email" value="<?php echo $this->record ? $this->record->getReportEmail() : '' ?>">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Database</legend>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="database_type">Driver</label>
                            <div class="col-md-8">
                                <select id="database_type" name="database_type" class="form-control">
                                    <?php $dbType = $this->record ? $this->record->getDatabaseType() : false ?>
                                    <option value="mysql"<?php echo $dbType && $dbType == 'mysql' ? ' selected' : '' ?>>MySQL</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="database_host">Host</label>
                            <div class="col-md-8">
                                <input id="database_host" name="database_host" placeholder="127.0.0.1" class="form-control input-md" type="text" value="<?php echo $this->record ? $this->record->getDatabaseHost() : '' ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="database_name">Name</label>
                            <div class="col-md-8">
                                <input id="database_name" name="database_name" placeholder="projectdb" class="form-control input-md" type="text" value="<?php echo $this->record ? $this->record->getDatabaseName() : '' ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="database_user">User</label>
                            <div class="col-md-8">
                                <input id="database_user" name="database_user" placeholder="root" class="form-control input-md" type="text" pattern="[a-z]+" title="Do not use spaces or symbols." value="<?php echo $this->record ? $this->record->getDatabaseUsername() : '' ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="database_password">Password</label>
                            <div class="col-md-8">
                                <input id="database_password" name="database_password" placeholder="" class="form-control input-md" type="password" value="<?php echo $this->record ? $this->record->getDatabasePassword() : '' ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="database_prefix">Prefix</label>
                            <div class="col-md-8">
                                <input id="database_prefix" name="database_prefix" placeholder="" class="form-control input-md" type="text" pattern="[a-z]+" title="Do not use spaces or symbols." value="<?php echo $this->record ? $this->record->getDatabasePrefix() : '' ?>">
                                <span class="help-block">Using a prefix enables you to run multiple project using a single database.</span>
                            </div>
                        </div>

                    </fieldset>
                </div>
                <div class="panel-footer text-right">
                    <button type="submit" class="btn btn-success"><span class="ftools-ok"></span> <?php echo $this->record ? 'Save' : 'Create' ?></button>
                    <input type="hidden" value="<?php echo $this->projectId ?>" name="project_id" id="project_id" />
                </div>
            </div>
        </form>
    </div>
</div>