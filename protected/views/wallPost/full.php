<div id="optionsWrapper" class="inlineblock">
    <div class="inlineblock">
        <a href="#" id="friendsNotifications" id="friendsNotifications"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/amigos.png"/></a>
            </div>
            <div  class="inlineblock">
                <a href="#" class="notificationButton">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/arboles.png"/>
                </a>
            </div>
            <div  class="inlineblock">
                <a href="#" class="notificationButton">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/grupos.png"/>
                </a>
            </div>
            <div id="notificationsFlyoutWrapper"></div>
            </div>
            <div id="searchBarWrapper" class="inlineblock">
                <form id="searchForm" method="GET" action="/search#php" onsubmit="//doSubmit(this); return false;">
                    <div id="searchInputWrapper" class="inlineblock">
                        <span><input type="text" id="searchBar" name="value" /></span>
                    </div>
                    <div id="searchWrapper" class="inlineblock">
                        <span><button id="searchButton" type="submit"></button></span>
                    </div>
                </form>
                <div id="searchResultsWrapper" class="inlineblock">
                    <div id="searchResultsContainer" class="inlineblock">
                        <ul id="searchResults">
                        </ul>
                    </div>
                </div>
            </div>
            <div id="settingsWrapper" class="inlineblock">
                <div id="settingsOptionsWrapper" class="inlineblock">
                    <span id="settingsOption">
                        <a href="#" ></a>
                        <a href="/Wahapi/doLogout.php">Cerrar sesi&oacute;n</a>
                    </span>
                </div>
                <div id="logoutWrapper"  class="logout">
                    <span id="logout"></span>
                </div>
            </div>
        </div>
        <div id="mainContainer">
            <div id="leftMenuColumn">
                <div id="menuTabs">
                    <div class="tabsContainer">
                        <div class="tab">
                            <span id="home">
                                <a href="<?php echo Yii::app()->request->baseUrl; ?>">Inicio</a>
                            </span>
                        </div>
                        <div class="tab2">
                            <span id="user">
                                <strong><?php echo Yii::app()->user->getState('name') ?></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div id="profileIdentity">
                    <div id="profileNameWrapper">
                        <span class="standardText">
                            <?php echo Yii::app()->user->getState('name') ?>
                            <?php echo Yii::app()->user->getState('last_name') ?>
                        </span>
                    </div>
                    <div id="profileImageWrapper">
                        <img class="profileImageMed" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash4/c33.33.417.417/s160x160/420883_330064070365591_1264195302_n.jpg" />
                    </div>
                </div>
                <!-- <div id="profileLevel">
                    <div id="profileLevelTitleWrapper">
                        <span class="standardText">Nivel de Puntuaci&oacute;n</span>
                    </div>
                    <div id="profileLevelImageWrapper">
                        <img />3
                    </div>
                    <div id="profileLevelNameWrapper">
                        <span class="profileLevelName">Big tree</span>
                    </div>
                </div>
                <div id="profileCalendar">
                    <div id="profileCalendarTitleWrapper">
                        <span class="standardText">Calendario</span>
                    </div>
                    <div id="profileCalendarDateWrapper">
                        <span class="profileCalendarDate">Octubre 2013</span>
                    </div>
                    <div id="profileCalendarWrapper">

                    </div>
                    <div id="profileCalendarEventsWrapper">
                    </div>
                </div> -->
            </div>
            <div id="centerMainColumn">
                <div id="mainOptions">
                    <div class="tabsContainer2">
                        <a class="tab_principal" href="#">
                            <div class="notificon">
                                <span class="newnotification">1</span>
                            </div>
                        </a>
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mensajes_tab.png"/>
                        <a class="tab_principal" href="#">
                            <div class="notificon">
                                <span>1</span>
                            </div>
                        </a>
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/amigos_tab.png"/>
                        <a class="tab_principal" href="#">
                            <div class="notificon">
                                <span>1</span>
                            </div>
                        </a>
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/grupos_tab.png"/>
                        <a class="tab_principal" href="#">
                            <div class="notificon">
                                <span>1</span>
                            </div>
                        </a>
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/arboles_tab.png"/>
                        <a class="tab_principal" href="#">
                            <div class="notificon">
                                <span>1</span>
                            </div>
                        </a>
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/fotos_tab.png"/>
                    </div>
                </div>
                <!-- <div id="containerTabsPost">
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1"><strong>Status</strong></a></li>
                            <li><a href="#tabs-2"><strong>Denuncio</strong></a></li>
                            <li><a href="#tabs-3"><strong>Actividad</strong></a></li>
                        </ul>
                        <div id="tabs-1">
                            <form method="POST" action="profile.php" data-action="status" id="statusForm" onsubmit="doSubmit(this);
                return false;">
                                <span>
                                    <input type="text" placeholder="Escribe que est&aacute;s pensando" name="status" id="status" />
                                    <span id="statusPhoto"></span>
                                </span>
                                <button class="greenButton">Publicar</button>
                            </form>
                        </div>
                        <div id="tabs-2">
                            <span>
                                <input type="text" placeholder="Escribe tu denuncio aqu&iacute;" id="denuncio"/>
                                <span id="statusPhoto"></span>
                            </span>
                            <button class="greenButton">Publicar</button>
                        </div>
                        <div id="tabs-3">
                            <table>
                                <tr>
                                    <td><input type="text" placeholder="Nombre de la Actividad" id="activityname"/></td>
                                    <td><input type="text" placeholder="Lugar" id="place"/></td>
                                </tr>
                                <tr>
                                    <td><input type="text" placeholder="Fecha" id="date"/><img /></td>
                                    <td><input type="text" placeholder="Hora" id="hour"/></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <textarea placeholder="Detalles" id="details" style="width: 315px; max-width: 315px;"></textarea>
                                        <span id="statusPhoto"></span>
                                    </td>
                                    <td>
                                        <button class="greenButton">Publicar</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div> -->
                <div id="containerTabsPost">
                <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'Status' => array('ajax' => $this->createUrl('/wallpost/status')),
                        'Denuncio' => array('ajax' => $this->createUrl('/wallpost/complaint')),
                        // panel 3 contains the content rendered by a partial view
                    ),
                    // additional javascript options for the tabs plugin
                    'options' => array(
                        'collapsible' => true,
                    ),
                ));?>
                </div>
                <div id="posts">
                    <ol>
                        <li class="psbody">
                            <div class="psimg">
                                <img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/50488_330049117033753_483067197_q.jpg" width="100px" height="100px"/>
                            </div>
                            <div class="pstext">
                                <div class="psuser">
                                    <strong>Colombia P&uacute;blica</strong>
                                </div>
                                Esto es Wahapi! &uacute;nase a la nueva red social dedicada a la protecci&oacute;n y conservaci&oacute;n del medio ambiente.
                                <div class="pslike">
                                    <a href="#">
                                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/like.png">
                                        <span class="textlike2">Like</span>
                                    </a>
                                    <a href="#">
                                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dislike.png" class="dislikeButton">
                                        <span class="textlike">Dislike</span>
                                    </a>
                                    <a href="#">
                                        <span class="textlike2">-</span>
                                        <span class="textlike2">Compartir</span>
                                    </a>
                                </div> 
                            </div> 
                        </li>
                        <li>
                            <div class="bgcmt">
                                <div class="cmtsbodyps">
                                    <img class="imgcom"src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/s48x48/50488_330049117033753_483067197_q.jpg" width="32px" height="32px">
                                    <input type="text" placeholder="Escribe un comentario" name="comment" id="comment">
                                </div>
                            </div>
                        </li>
                    </ol>
                </div>
                <div id="posts">
                    <ol>
                        <li class="stibody">
                            <div class="stiimg">
                                <img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/50488_330049117033753_483067197_q.jpg"/>
                            </div> 
                            <div class="stitext">
                                <div class="psuser">
                                    <strong>Colombia P&uacute;blica</strong>
                                </div>
                                Esto es Wahapi!
                                <div id="imgpost">
                                    <img class="imgpost" width="110px" height="110px"/>
                                    <img class="imgpost" width="110px" height="110px"/>
                                    <img class="imgpost" width="110px" height="110px"/>
                                    <img class="imgpost" width="110px" height="110px"/>
                                </div>
                                <div class="pslike">
                                    <a href="#">
                                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/like.png">
                                        <span class="textlike2">Like</span>
                                    </a>
                                    <a href="#">
                                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dislike.png" class="dislikeButton">
                                        <span class="textlike">Dislike</span>
                                    </a>
                                    <a href="#">
                                        <span class="textlike2">-</span>
                                        <span class="textlike2">Compartir</span>
                                    </a>
                                </div> 
                            </div> 
                        </li>
                        <li>
                            <div class="likespost">
                                <div class="likeposttext">
                                    A 
                                    <a href="#">x</a>
                                     le gusta a 
                                    <a href="#">y</a>
                                       y a 
                                    <a href="#">z</a>
                                </div>
                            </div>
                            <div class="bgcmt">
                                <div class="cmtsbodyps">
                                    <img class="imgcom"src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/s48x48/50488_330049117033753_483067197_q.jpg" width="32px" height="32px">
                                    <div class="cmtext">Holaaaaaaa</div>
                                    <div class="cmtextlikes">
                                        <a href="#">4 likes</a> - <a href="#">like</a>
                                    </div>
                                </div>
                            <div class="cmtsbodyps">
                                <img class="imgcom"src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/s48x48/50488_330049117033753_483067197_q.jpg" width="32px" height="32px">
                                <input type="text" placeholder="Escribe un comentario" name="commentps" id="commentps">
                            </div>
                        </div>
                    </li>
                </ol>
            </div>
            <div id="posts">
                <ol> 
                    <li class="stbody">
                        <div class="stimg">
                            <img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/50488_330049117033753_483067197_q.jpg"/>
                        </div> 
                        <div class="sttext">
                            <div class="psuser"><strong>Colombia P&uacute;blica</strong></div>
                                Esto es Wahapi!
                                <div class="pslike">
                                    <a href="#">
                                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/like.png">
                                        <span class="textlike2">Like</span>
                                    </a>
                                    <a href="#">
                                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dislike.png" class="dislikeButton">
                                        <span class="textlike">Dislike</span>
                                    </a>
                                    <a href="#">
                                        <span class="textlike2">-</span>
                                        <span class="textlike2">Compartir</span>
                                    </a>
                                </div> 
                            </div> 
                        </li>
                        <li>
                            <div class="bgcmt">
                                <div class="cmtsbodyps">
                                    <img class="imgcom"src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/s48x48/50488_330049117033753_483067197_q.jpg" width="32px" height="32px">
                                    <input type="text" placeholder="Escribe un comentario" name="comment" id="comment">
                                </div>
                            </div>
                        </li>
                    </ol>
                </div>
                <footer class="footer">
                    <div class="txtfooter">Copyright &COPY; Wahapi, Powered by Colombia P&uacute;blica &REG;</div>
                </footer>
            </div>
        </div>
        <span id="error"></span>