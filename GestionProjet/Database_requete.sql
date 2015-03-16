-- phpMyAdmin SQL Dump
-- version 3.2.0-rc1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Genere le : Mer 05 Mai 2010 a 11:51
-- Version du serveur: 5.1.37
-- Version de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de donnees: `tootlist`
--


--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`idcategories`, `description`, `title_fr`, `title_en`, `tags`, `categorie_idcategories`) VALUES
(1, '', 'musique', 'music', 'mp3,musique,hit,concert', NULL),
(2, '', 'rock', 'rock', 'u2,rock,virgin', 1),
(3, '', 'electro', 'electro', 'david guetta,daf punk,dj', 1),
(4, '', 'film', 'movie', 'allocine,film,cine', NULL),
(5, '', 'serie tv', 'serie tv', 'the big bang theory,24,californication', 4),
(6, '', 'divers', 'various', 'poubelle', NULL),
(7, '', 'utilisateur', 'user', '', NULL),
(8, '', 'profil', 'profile', '', 7),
(9, '', 'Discussion', 'Discussion', '', 7),
(10, NULL, 'chat', 'chat', NULL, 7),
(11, 'Meteo', 'meteo', 'weather', NULL, NULL);

--
-- Contenu de la table `list`
--

INSERT INTO `list` (`idList`, `list_idList`, `nb_duplication`, `nb_view`, `title`, `description`, `tag`, `categorie_idcategories`, `status`, `permission`) VALUES
(76, 0, 0, 0, 'NotificationProfil', NULL, NULL, 8, 1, 1),
(77, 0, 0, 0, 'FriendProfil', NULL, NULL, 8, 1, 1),
(78, 0, 0, 0, 'RecallProfil', NULL, NULL, 8, 1, 1),
(79, 0, 0, 19, 'Musique d''admin', '', 'Hurt, Skillet, The Used', 2, 1, 1),
(80, 0, 0, 13, 'Photos d''admin', '', 'megan fox, france, google', 6, 1, 1),
(81, 0, 0, 12, 'Video d''admin', '<p>Les videos de l''administrateur<strong></strong></p>', 'Toy story, iron man2', 5, 1, 1),
(82, 0, 0, 0, 'StructureDeProfil', NULL, NULL, 8, 1, 1),
(83, 0, 0, 5, 'meteo', NULL, NULL, 11, 1, 1),
(84, 0, 0, 8, 'evenement d''admin', '', 'tootlist', 6, 1, 1),
(85, 0, 0, 8, 'Favoris d''admin', '', 'Facebook, twitter, chatroulette', 6, 1, 1),
(86, 0, 0, 0, 'Profil', NULL, NULL, 8, 1, 1),
(87, 0, 0, 2, 'Envies d''admin', '', 'envies', 6, 1, 1),
(88, 87, 1, 1, 'Envies d''admin - duplication', '', 'envies', 6, 1, 1),
(89, 0, 0, 0, 'Mon repertoire telephonique d''admin', '', '', 6, 1, 1);



--
-- Contenu de la table `user`
--

INSERT INTO `user` (`idUser`, `email`, `first`, `ip`, `language`, `login`, `online`, `quota_list`, `password`, `status`, `privilege`, `token`) VALUES
(1, 'tootlist@gmail.com', 1, '127.0.0.1', 'fr', 'root', 1, 6, '21232f297a57a5a743894a0e4a801fc3', 1, 2, '');

--
-- Contenu de la table `user_has_list`
--

INSERT INTO `user_has_list` (`user_idUser`, `list_idList`) VALUES
(1, 76),
(1, 77),
(1, 78),
(1, 79),
(1, 80),
(1, 81),
(1, 82),
(1, 83),
(1, 84),
(1, 85),
(1, 86),
(1, 87),
(1, 88),
(1, 89);




--
-- Contenu de la table `type`
--

INSERT INTO `type` (`idtype`, `model_id`) VALUES
(448, 22),
(449, 22),
(450, 22),
(451, 20),
(452, 20),
(453, 10),
(454, 10),
(455, 10),
(456, 10),
(457, 20),
(458, 11),
(459, 11),
(460, 11),
(461, 20),
(462, 19),
(463, 20),
(464, 25),
(465, 25),
(466, 25),
(467, 17),
(468, 17),
(469, 20),
(470, 14),
(471, 20),
(472, 13),
(473, 13),
(474, 13),
(475, 20),
(476, 20),
(477, 8),
(478, 8),
(479, 8),
(480, 8),
(481, 8),
(482, 8),
(483, 8),
(484, 8),
(485, 8),
(486, 8),
(487, 8),
(488, 8),
(489, 8),
(490, 8),
(491, 8),
(492, 8),
(493, 8),
(494, 8),
(495, 8),
(496, 8),
(497, 8),
(498, 8),
(499, 8),
(500, 8),
(501, 8),
(502, 8),
(503, 8),
(504, 8),
(505, 15),
(506, 15),
(507, 15),
(508, 20),
(509, 15),
(510, 15),
(511, 15),
(512, 26),
(513, 20);


--
-- Contenu de la table `item`
--

INSERT INTO `item` (`idItem`, `list_idList`, `position`, `type_idtype`) VALUES
(395, 79, 3, 448),
(396, 79, 3, 449),
(397, 79, 3, 450),
(398, 76, 0, 451),
(399, 76, 0, 452),
(400, 80, 4, 453),
(401, 80, 4, 454),
(402, 80, 4, 455),
(403, 80, 4, 456),
(404, 76, 0, 457),
(405, 81, 3, 458),
(406, 81, 3, 459),
(407, 81, 3, 460),
(408, 76, 0, 461),
(409, 82, 0, 462),
(410, 76, 0, 463),
(411, 83, 0, 464),
(412, 83, 0, 465),
(413, 83, 0, 466),
(414, 84, 5, 467),
(415, 84, 5, 468),
(416, 76, 0, 469),
(417, 78, 0, 470),
(418, 76, 0, 471),
(419, 85, 5, 472),
(420, 85, 5, 473),
(421, 85, 5, 474),
(422, 76, 0, 475),
(423, 76, 0, 476),
(424, 86, 0, 477),
(425, 86, 1, 478),
(426, 86, 2, 479),
(427, 86, 3, 480),
(428, 86, 4, 481),
(429, 86, 5, 482),
(430, 86, 6, 483),
(431, 86, 7, 484),
(432, 86, 8, 485),
(433, 86, 9, 486),
(434, 86, 10, 487),
(435, 86, 11, 488),
(436, 86, 12, 489),
(437, 86, 13, 490),
(438, 86, 14, 491),
(439, 86, 15, 492),
(440, 86, 16, 493),
(441, 86, 17, 494),
(442, 86, 18, 495),
(443, 86, 19, 496),
(444, 86, 20, 497),
(445, 86, 21, 498),
(446, 86, 22, 499),
(447, 86, 23, 500),
(448, 86, 24, 501),
(449, 86, 25, 502),
(450, 86, 26, 503),
(451, 86, 27, 504),
(452, 87, 2, 505),
(453, 87, 2, 506),
(454, 87, 2, 507),
(455, 76, 0, 508),
(456, 88, 0, 509),
(457, 88, 1, 510),
(458, 88, 2, 511),
(459, 89, 13, 512),
(460, 76, 0, 513);




--
-- Contenu de la table `bookmark`
--

INSERT INTO `bookmark` (`item_idItem`, `title`, `link`, `description`, `picture`, `tags`) VALUES
(419, 'Facebook', 'http://www.facebook.com', 'Facebook est un reseau social', 'http://t1.gstatic.com/images?q=tbn:o5r5c7QVjb5iQM:http://www.xaviergalaup.fr/blog/wp-content/uploads/2010/01/facebook-f-logo.jpg', 'Facebook'),
(420, 'Twitter', 'http://www.twitter.com', 'Twitter est un reseau social base sur des tweets', 'http://t1.gstatic.com/images?q=tbn:1Ua1-o7kM5ncwM:http://www.touchephd.com/blog/wp-content/themes/FREEmium/img/icon-twitter.png', 'Twitter'),
(421, 'Chatroulette', 'http://www.chatroulette.com', 'Chatroulette est un site internet qui permet de rencontrer des etrangers', 'http://t2.gstatic.com/images?q=tbn:TGtOALnrC4exBM:http://19.media.tumblr.com/tumblr_kv4rx1X3dv1qa8kfao1_500.png', 'Chatroulette');



--
-- Contenu de la table `city`
--

INSERT INTO `city` (`item_idItem`, `city`, `country`, `woeid`) VALUES
(411, 'evry', 'FR', '590397'),
(412, 'voisenon', 'FR', '632574'),
(413, 'Vancouver', 'CA', '9807');

--
-- Contenu de la table `configuration`
--

INSERT INTO `configuration` (`idConfiguration`, `help`, `language`, `forbidden_word`, `profile`, `quota_list_user`, `quota_list_user_parent`, `status`) VALUES
(1, '<h1> Bienvenue dans Tootlist </h1>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor justo sed dolor interdum venenatis. Donec laoreet turpis ut ipsum pharetra a vestibulum nunc pulvinar. Duis lacinia lorem non odio cursus sagittis et quis est. Nulla fringilla pharetra viverra. Maecenas risus leo, iaculis quis varius sit amet, convallis vitae neque. Nullam sagittis nisi sit amet lacus feugiat iaculis vitae id justo. Nulla cursus dui in lorem laoreet eget pulvinar lorem item ultricies. Etiam risus nisi, blandit ac ultricies eu, rhoncus et nisl. Maecenas vestibulum aliquet lorem et elementum. Nunc mattis blandit diam, et laoreet nisl hendrerit ac. Donec bibendum adipiscing ipsum id fringilla. Praesent tempor, eros sed vehicula rutrum, lacus dolor lobortis augue, vel pretium ante eros eu neque. Maecenas elit ante, lacinia faucibus imperdiet sit amet, aliquam sit amet nisi. Duis eget pretium neque.</p>\r\n\r\n<p>Maecenas luctus scelerisque dui, sit amet tristique eros vulputate ut. Pellentesque non pretium enim. Nulla facilisi. Aliquam imperdiet tortor vitae erat tempus id dignissim neque commodo. Suspendisse commodo velit at urna dapibus volutpat. Vivamus venenatis vehicula dolor, id dictum justo tincidunt a. Fusce imperdiet feugiat aliquet. Mauris placerat, neque a tincidunt hendrerit, dolor lacus gravida erat, id commodo ipsum mauris quis ligula. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec consectetur turpis vel sem pellentesque eu blandit augue feugiat. Phasellus eget lorem neque. Integer magna nisi, mattis eu tempor ut, hendrerit et mauris. Ut sit amet sapien nisi, a commodo leo. Donec odio erat, tempus quis volutpat sed, venenatis sed turpis. Nam a dictum quam.</p>\r\n\r\n<p>Nulla non velit non neque tincidunt venenatis eget vel tellus. Sed tincidunt odio eu nisi congue ullamcorper. In sodales ipsum eget nisl cursus luctus. Nam ac lectus eleifend nunc blandit facilisis. Nulla commodo varius magna, sit amet sollicitudin mi eleifend et. Aliquam erat volutpat. Fusce nec nulla porta magna lobortis scelerisque sit amet quis justo. Quisque condimentum porttitor neque eu mattis. Etiam eget condimentum libero. Curabitur tincidunt dignissim erat, consectetur fermentum massa tincidunt ultricies.</p>\r\n\r\n<p>Praesent convallis mattis justo, non aliquet sem gravida vitae. Integer ultricies nisi sed dui sodales molestie. Vestibulum purus tellus, ultricies eu ultrices et, varius vitae nibh. Ut vitae eros non tellus varius rhoncus. Suspendisse a risus quis diam ultrices gravida id luctus ipsum. Fusce consectetur tempor tortor, eu accumsan tellus laoreet sed. Vestibulum in neque odio, in dignissim magna. Phasellus mollis lacinia est sed ultricies. Nulla facilisi. Vivamus arcu nibh, consectetur nec varius vitae, semper eget magna. Pellentesque scelerisque orci sit amet justo mattis aliquet. Pellentesque eget sem vitae sapien ullamcorper volutpat. Sed at augue et nibh dapibus porttitor. Cras cursus mi vitae neque pulvinar dictum. Maecenas vel metus ac felis rhoncus malesuada non non quam. Donec posuere ultrices risus, vulputate consectetur libero convallis ultrices. Duis ultrices elit id mauris aliquet porta porttitor augue lobortis. Praesent quam sapien, blandit sed imperdiet vel, molestie at lorem.</p>\r\n\r\n<p>Nulla laoreet tristique urna, at euismod dolor tristique eu. Nunc tempus tortor sed metus pharetra gravida eleifend ligula semper. Integer lacinia bibendum erat nec convallis. Donec id volutpat lacus. Nulla in nisl nibh. Aenean tortor mi, laoreet nec porttitor eget, fringilla ut nisl. Curabitur augue est, luctus in dictum eget, elementum ac velit. Phasellus elit nisi, rutrum sed adipiscing eget, gravida vel neque. Curabitur gravida augue et lorem luctus id pretium nisi dignissim. Suspendisse at lorem at velit molestie sagittis. Nullam tristique lacus eu odio eleifend et elementum tellus sollicitudin. Aenean lobortis pretium est, ac fringilla arcu feugiat at. Nulla ante nunc, suscipit lobortis cursus nec, sagittis eu nisi. Quisque non congue tortor. Nam lorem elit, posuere posuere fringilla ut, congue eget nunc.</p>', 'fr', '0', '<?xml version="1.0"?>\r\n<form>\r\n  <elem name="civility" type="Select" value="Feminin,Masculin" />\r\n  <elem name="name" type="Text" required="true"/>\r\n  <elem name="firstname" type="Text" required="true"/>\r\n  <elem name="photo" type="Text"/>\r\n  <elem name="dateBirthday" type="Date" description="Cliquez en haut pour changer d''echelle de temps"  />\r\n  <elem name="relationship" type="Select" value="Celibataire,En couple,Fiance,Marie,Veuf,C''est complique,Dans une relation ouverte" />\r\n  <elem name="interestedBy" type="Checkbox" value="Feminin,Masculin"/>  \r\n  <elem name="politicView" type="Text" />\r\n  <elem name="religiousView" type="Text" />\r\n  <elem name="activities" type="Wysiwyg"/>\r\n  <elem name="interest" type="Wysiwyg" />\r\n  <elem name="music" type="Wysiwyg" />\r\n  <elem name="tvshow" type="Wysiwyg" />\r\n  <elem name="movie" type="Wysiwyg"  />\r\n  <elem name="book" type="Wysiwyg" />\r\n  <elem name="aboutMe" type="Wysiwyg" />\r\n  <elem name="mobile" type="Text" required="true"/>\r\n  <elem name="phone" type="Text" />\r\n  <elem name="adress" type="Text"  required="true"/>\r\n  <elem name="postalCode" type="Text"  required="true"/>\r\n  <elem name="city" type="Text"  required="true"/>\r\n  <elem name="city" type="Countries"  required="true"/>\r\n  <elem name="webSite" type="Text" />\r\n  <elem name="diploma" type="Wysiwyg"  required="true"/>\r\n  <elem name="experience" type="Wysiwyg"  required="true"/>\r\n  <elem name="company" type="Wysiwyg"  required="true"/>\r\n  <elem name="priority" type="Select" value="WebSite,Logiciel" description="Vous pouvez choisir quelle application sera prioritaire pour la synchronisation" />\r\n</form>\r\n', 20, 5, 1);


INSERT INTO `configuration` (`idConfiguration`, `help`, `language`, `forbidden_word`, `profile`, `quota_list_user`, `quota_list_user_parent`, `status`) VALUES
(2, '<h1> Welcome to Tootlist </h1>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor justo sed dolor interdum venenatis. Donec laoreet turpis ut ipsum pharetra a vestibulum nunc pulvinar. Duis lacinia lorem non odio cursus sagittis et quis est. Nulla fringilla pharetra viverra. Maecenas risus leo, iaculis quis varius sit amet, convallis vitae neque. Nullam sagittis nisi sit amet lacus feugiat iaculis vitae id justo. Nulla cursus dui in lorem laoreet eget pulvinar lorem item ultricies. Etiam risus nisi, blandit ac ultricies eu, rhoncus et nisl. Maecenas vestibulum aliquet lorem et elementum. Nunc mattis blandit diam, et laoreet nisl hendrerit ac. Donec bibendum adipiscing ipsum id fringilla. Praesent tempor, eros sed vehicula rutrum, lacus dolor lobortis augue, vel pretium ante eros eu neque. Maecenas elit ante, lacinia faucibus imperdiet sit amet, aliquam sit amet nisi. Duis eget pretium neque.</p>\r\n\r\n<p>Maecenas luctus scelerisque dui, sit amet tristique eros vulputate ut. Pellentesque non pretium enim. Nulla facilisi. Aliquam imperdiet tortor vitae erat tempus id dignissim neque commodo. Suspendisse commodo velit at urna dapibus volutpat. Vivamus venenatis vehicula dolor, id dictum justo tincidunt a. Fusce imperdiet feugiat aliquet. Mauris placerat, neque a tincidunt hendrerit, dolor lacus gravida erat, id commodo ipsum mauris quis ligula. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec consectetur turpis vel sem pellentesque eu blandit augue feugiat. Phasellus eget lorem neque. Integer magna nisi, mattis eu tempor ut, hendrerit et mauris. Ut sit amet sapien nisi, a commodo leo. Donec odio erat, tempus quis volutpat sed, venenatis sed turpis. Nam a dictum quam.</p>\r\n\r\n<p>Nulla non velit non neque tincidunt venenatis eget vel tellus. Sed tincidunt odio eu nisi congue ullamcorper. In sodales ipsum eget nisl cursus luctus. Nam ac lectus eleifend nunc blandit facilisis. Nulla commodo varius magna, sit amet sollicitudin mi eleifend et. Aliquam erat volutpat. Fusce nec nulla porta magna lobortis scelerisque sit amet quis justo. Quisque condimentum porttitor neque eu mattis. Etiam eget condimentum libero. Curabitur tincidunt dignissim erat, consectetur fermentum massa tincidunt ultricies.</p>\r\n\r\n<p>Praesent convallis mattis justo, non aliquet sem gravida vitae. Integer ultricies nisi sed dui sodales molestie. Vestibulum purus tellus, ultricies eu ultrices et, varius vitae nibh. Ut vitae eros non tellus varius rhoncus. Suspendisse a risus quis diam ultrices gravida id luctus ipsum. Fusce consectetur tempor tortor, eu accumsan tellus laoreet sed. Vestibulum in neque odio, in dignissim magna. Phasellus mollis lacinia est sed ultricies. Nulla facilisi. Vivamus arcu nibh, consectetur nec varius vitae, semper eget magna. Pellentesque scelerisque orci sit amet justo mattis aliquet. Pellentesque eget sem vitae sapien ullamcorper volutpat. Sed at augue et nibh dapibus porttitor. Cras cursus mi vitae neque pulvinar dictum. Maecenas vel metus ac felis rhoncus malesuada non non quam. Donec posuere ultrices risus, vulputate consectetur libero convallis ultrices. Duis ultrices elit id mauris aliquet porta porttitor augue lobortis. Praesent quam sapien, blandit sed imperdiet vel, molestie at lorem.</p>\r\n\r\n<p>Nulla laoreet tristique urna, at euismod dolor tristique eu. Nunc tempus tortor sed metus pharetra gravida eleifend ligula semper. Integer lacinia bibendum erat nec convallis. Donec id volutpat lacus. Nulla in nisl nibh. Aenean tortor mi, laoreet nec porttitor eget, fringilla ut nisl. Curabitur augue est, luctus in dictum eget, elementum ac velit. Phasellus elit nisi, rutrum sed adipiscing eget, gravida vel neque. Curabitur gravida augue et lorem luctus id pretium nisi dignissim. Suspendisse at lorem at velit molestie sagittis. Nullam tristique lacus eu odio eleifend et elementum tellus sollicitudin. Aenean lobortis pretium est, ac fringilla arcu feugiat at. Nulla ante nunc, suscipit lobortis cursus nec, sagittis eu nisi. Quisque non congue tortor. Nam lorem elit, posuere posuere fringilla ut, congue eget nunc.</p>', 'en', '0', '<?xml version="1.0"?>\r\n<form>\r\n  <elem name="civility" type="Select" value="Feminin,Masculin" />\r\n  <elem name="name" type="Text" required="true"/>\r\n  <elem name="firstname" type="Text" required="true"/>\r\n  <elem name="photo" type="Text"/>\r\n  <elem name="dateBirthday" type="Date" description="Cliquez en haut pour changer d''echelle de temps"  />\r\n  <elem name="relationship" type="Select" value="Celibataire,En couple,Fiance,Marie,Veuf,C''est complique,Dans une relation ouverte" />\r\n  <elem name="interestedBy" type="Checkbox" value="Feminin,Masculin"/>  \r\n  <elem name="politicView" type="Text" />\r\n  <elem name="religiousView" type="Text" />\r\n  <elem name="activities" type="Wysiwyg"/>\r\n  <elem name="interest" type="Wysiwyg" />\r\n  <elem name="music" type="Wysiwyg" />\r\n  <elem name="tvshow" type="Wysiwyg" />\r\n  <elem name="movie" type="Wysiwyg"  />\r\n  <elem name="book" type="Wysiwyg" />\r\n  <elem name="aboutMe" type="Wysiwyg" />\r\n  <elem name="mobile" type="Text" required="true"/>\r\n  <elem name="phone" type="Text" />\r\n  <elem name="adress" type="Text"  required="true"/>\r\n  <elem name="postalCode" type="Text"  required="true"/>\r\n  <elem name="city" type="Text"  required="true"/>\r\n  <elem name="city" type="Countries"  required="true"/>\r\n  <elem name="webSite" type="Text" />\r\n  <elem name="diploma" type="Wysiwyg"  required="true"/>\r\n  <elem name="experience" type="Wysiwyg"  required="true"/>\r\n  <elem name="company" type="Wysiwyg"  required="true"/>\r\n  <elem name="priority" type="Select" value="WebSite,Logiciel" description="Vous pouvez choisir quelle application sera prioritaire pour la synchronisation" />\r\n</form>\r\n', 20, 5, 1);

--
-- Contenu de la table `css`
--


--
-- Contenu de la table `dailymotion`
--


--
-- Contenu de la table `deezer`
--


--
-- Contenu de la table `directory`
--

INSERT INTO `directory` (`item_idItem`, `address`, `business_phone`, `city`, `country`, `email`, `email2`, `firstname`, `home_phone`, `lastname`, `login`, `phone`, `postal_code`, `website`) VALUES
(459, '8 impasse des lys ', '', 'Voisenon', 'France', 'thomaroger@aol.com', '', 'Thomas', '0160689513', 'ROGER', 'lostprofetmars2', '', '77950', 'www.thomaroger.fr');

--
-- Contenu de la table `disable`
--


--
-- Contenu de la table `document`
--


--
-- Contenu de la table `envie`
--

INSERT INTO `envie` (`item_idItem`, `description`, `title`) VALUES
(452, 'Parce qu''on dort pas beaucoup', 'Dormir'),
(453, 'Parce que ca serait bien', 'Finir Tootlist'),
(454, 'Parce que sinon c''est la loose', 'Avoir une bonne note'),
(456, 'Parce qu''on dort pas beaucoup', 'Dormir'),
(457, 'Parce que ca serait bien', 'Finir Tootlist'),
(458, 'Parce que sinon c''est la loose', 'Avoir une bonne note');

--
-- Contenu de la table `event`
--

INSERT INTO `event` (`item_idItem`, `date_begin`, `date_end`, `description`, `location`, `title`) VALUES
(414, '2010-05-05 00:00:00', '2010-05-05 00:00:00', '<p>Rendre les sources de Tootlist<br />Rendre la documentation</p>', '27 rue de fontarabie, Paris', 'Rendu des sources de Tootlist'),
(415, '2010-06-24 00:00:00', '2010-06-24 00:00:00', 'Soutenance de projet', '27 rue de fontarabie, Paris', 'Soutenance de projet');

--
-- Contenu de la table `fight`
--


--
-- Contenu de la table `friend`
--

--
-- Contenu de la table `log`
--

INSERT INTO `log` (`idLog`, `model_id`, `record_id`, `description`, `title`) VALUES
(964, 2, 24, 'tootlist@gmail.com a cree une liste : NotificationProfil', 'INFORMATION'),
(965, 2, 24, 'tootlist@gmail.com a cree une liste : FriendProfil', 'INFORMATION'),
(966, 2, 24, 'tootlist@gmail.com a cree une liste : RecallProfil', 'INFORMATION'),
(967, 2, 24, 'Inscription de tootlist@gmail.com', 'INFORMATION'),
(968, 2, 24, 'Validation du compte de tootlist@gmail.com', 'INFORMATION'),
(969, 2, 24, 'Connexion du compte de tootlist@gmail.com', 'INFORMATION'),
(970, 2, 24, 'tootlist@gmail.com a cree une liste : Musique d''admin', 'INFORMATION'),
(971, 2, 24, 'tootlist@gmail.com a cree une item de type musique(22)', 'INFORMATION'),
(972, 2, 24, 'tootlist@gmail.com a cree une item de type musique(22)', 'INFORMATION'),
(973, 2, 24, 'tootlist@gmail.com a cree une item de type musique(22)', 'INFORMATION'),
(974, 2, 24, 'tootlist@gmail.com a cree une item de type Notification(20)', 'INFORMATION'),
(975, 2, 1, 'Connexion du compte de tootlist@gmail.com', 'INFORMATION'),
(976, 2, 1, 'tootlist@gmail.com a cree une item de type Notification(20)', 'INFORMATION'),
(977, 2, 1, 'tootlist@gmail.com a cree une liste : Photos d''admin', 'INFORMATION'),
(978, 2, 1, 'tootlist@gmail.com a cree une item de type Photo(10)', 'INFORMATION'),
(979, 2, 1, 'tootlist@gmail.com a cree une item de type Photo(10)', 'INFORMATION'),
(980, 2, 1, 'tootlist@gmail.com a cree une item de type Photo(10)', 'INFORMATION'),
(981, 2, 1, 'tootlist@gmail.com a cree une item de type Photo(10)', 'INFORMATION'),
(982, 2, 1, 'tootlist@gmail.com a cree une item de type Notification(20)', 'INFORMATION'),
(983, 2, 1, 'tootlist@gmail.com a cree une liste : Video d''admin', 'INFORMATION'),
(984, 2, 1, 'tootlist@gmail.com a cree une item de type Film(11)', 'INFORMATION'),
(985, 2, 1, 'tootlist@gmail.com a cree une item de type Film(11)', 'INFORMATION'),
(986, 2, 1, 'tootlist@gmail.com a cree une item de type Film(11)', 'INFORMATION'),
(987, 2, 1, 'tootlist@gmail.com a cree une item de type Notification(20)', 'INFORMATION'),
(988, 2, 1, 'tootlist@gmail.com a cree une liste : StructureDeProfil', 'INFORMATION'),
(989, 2, 1, 'tootlist@gmail.com a cree une item de type structure(19)', 'INFORMATION'),
(990, 2, 1, 'tootlist@gmail.com a cree une item de type Notification(20)', 'INFORMATION'),
(991, 2, 1, 'tootlist@gmail.com a cree une liste : meteo', 'INFORMATION'),
(992, 2, 1, 'tootlist@gmail.com a cree une item de type meteo(25)', 'INFORMATION'),
(993, 2, 1, 'tootlist@gmail.com a cree une item de type meteo(25)', 'INFORMATION'),
(994, 2, 1, 'tootlist@gmail.com a cree une item de type meteo(25)', 'INFORMATION'),
(995, 2, 1, 'tootlist@gmail.com a cree une liste : evenement d''admin', 'INFORMATION'),
(996, 2, 1, 'tootlist@gmail.com a cree une item de type Evenement(17)', 'INFORMATION'),
(997, 2, 1, 'tootlist@gmail.com a cree une item de type Evenement(17)', 'INFORMATION'),
(998, 2, 1, 'tootlist@gmail.com a cree une item de type Notification(20)', 'INFORMATION'),
(999, 2, 1, 'tootlist@gmail.com a cree une item de type Rappel(14)', 'INFORMATION'),
(1000, 2, 1, 'tootlist@gmail.com a cree une item de type Notification(20)', 'INFORMATION'),
(1001, 2, 1, 'tootlist@gmail.com a cree une liste : Favoris d''admin', 'INFORMATION'),
(1002, 2, 1, 'tootlist@gmail.com a cree une item de type Favoris(13)', 'INFORMATION'),
(1003, 2, 1, 'tootlist@gmail.com a cree une item de type Favoris(13)', 'INFORMATION'),
(1004, 2, 1, 'tootlist@gmail.com a cree une item de type Favoris(13)', 'INFORMATION'),
(1005, 2, 1, 'tootlist@gmail.com a cree une item de type Notification(20)', 'INFORMATION'),
(1006, 2, 1, 'tootlist@gmail.com a cree une item de type Notification(20)', 'INFORMATION'),
(1007, 2, 1, 'tootlist@gmail.com a cree une liste : Profil', 'INFORMATION'),
(1008, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1009, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1010, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1011, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1012, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1013, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1014, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1015, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1016, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1017, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1018, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1019, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1020, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1021, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1022, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1023, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1024, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1025, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1026, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1027, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1028, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1029, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1030, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1031, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1032, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1033, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1034, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1035, 2, 1, 'tootlist@gmail.com a cree une item de type Profil(8)', 'INFORMATION'),
(1036, 2, 1, 'tootlist@gmail.com a cree une liste : Envies d''admin', 'INFORMATION'),
(1037, 2, 1, 'tootlist@gmail.com a cree une item de type Envie(15)', 'INFORMATION'),
(1038, 2, 1, 'tootlist@gmail.com a cree une item de type Envie(15)', 'INFORMATION'),
(1039, 2, 1, 'tootlist@gmail.com a cree une item de type Envie(15)', 'INFORMATION'),
(1040, 2, 1, 'tootlist@gmail.com a cree une item de type Notification(20)', 'INFORMATION'),
(1041, 2, 1, 'tootlist@gmail.com a cree une liste : Envies d''admin', 'INFORMATION'),
(1042, 2, 1, 'tootlist@gmail.com a cree une item de type Envie(15)', 'INFORMATION'),
(1043, 2, 1, 'tootlist@gmail.com a cree une item de type Envie(15)', 'INFORMATION'),
(1044, 2, 1, 'tootlist@gmail.com a cree une item de type Envie(15)', 'INFORMATION'),
(1045, 2, 1, 'tootlist@gmail.com a cree une liste : Mon repertoire telephonique d''admin', 'INFORMATION'),
(1046, 2, 1, 'tootlist@gmail.com a cree une item de type repertoire(26)', 'INFORMATION'),
(1047, 2, 1, 'tootlist@gmail.com a cree une item de type Notification(20)', 'INFORMATION'),
(1048, 2, 1, 'tootlist@gmail.com a modifie la liste : Profil', 'INFORMATION');

--
-- Contenu de la table `message`
--


--
-- Contenu de la table `metadata`
--

INSERT INTO `metadata` (`idMetadata`, `model_id`, `record_id`, `created_at`, `updated_at`) VALUES
(1434, 6, 76, '2010-05-05 10:40:53', '2010-05-05 10:40:53'),
(1435, 3, 964, '2010-05-05 10:40:53', '2010-05-05 10:40:53'),
(1436, 6, 77, '2010-05-05 10:40:53', '2010-05-05 10:40:53'),
(1437, 3, 965, '2010-05-05 10:40:53', '2010-05-05 10:40:53'),
(1438, 6, 78, '2010-05-05 10:40:53', '2010-05-05 10:40:53'),
(1439, 3, 966, '2010-05-05 10:40:53', '2010-05-05 10:40:53'),
(1440, 2, 24, '2010-05-05 10:40:53', '2010-05-05 10:43:20'),
(1441, 3, 967, '2010-05-05 10:40:53', '2010-05-05 10:40:53'),
(1442, 3, 968, '2010-05-05 10:42:25', '2010-05-05 10:42:25'),
(1443, 3, 969, '2010-05-05 10:43:20', '2010-05-05 10:43:20'),
(1444, 6, 79, '2010-05-05 10:44:47', '2010-05-05 10:44:47'),
(1445, 3, 970, '2010-05-05 10:44:47', '2010-05-05 10:44:47'),
(1446, 7, 395, '2010-05-05 10:46:39', '2010-05-05 10:46:39'),
(1447, 3, 971, '2010-05-05 10:46:39', '2010-05-05 10:46:39'),
(1448, 7, 396, '2010-05-05 10:46:39', '2010-05-05 10:46:39'),
(1449, 3, 972, '2010-05-05 10:46:39', '2010-05-05 10:46:39'),
(1450, 7, 397, '2010-05-05 10:46:39', '2010-05-05 10:46:39'),
(1451, 3, 973, '2010-05-05 10:46:39', '2010-05-05 10:46:39'),
(1452, 7, 398, '2010-05-05 10:46:39', '2010-05-05 10:46:39'),
(1453, 3, 974, '2010-05-05 10:46:39', '2010-05-05 10:46:39'),
(1454, 3, 975, '2010-05-05 10:51:54', '2010-05-05 10:51:54'),
(1455, 7, 399, '2010-05-05 10:51:55', '2010-05-05 10:51:55'),
(1456, 3, 976, '2010-05-05 10:51:55', '2010-05-05 10:51:55'),
(1457, 6, 80, '2010-05-05 10:56:25', '2010-05-05 10:56:25'),
(1458, 3, 977, '2010-05-05 10:56:25', '2010-05-05 10:56:25'),
(1459, 7, 400, '2010-05-05 11:00:28', '2010-05-05 11:00:28'),
(1460, 3, 978, '2010-05-05 11:00:28', '2010-05-05 11:00:28'),
(1461, 7, 401, '2010-05-05 11:00:28', '2010-05-05 11:00:28'),
(1462, 3, 979, '2010-05-05 11:00:29', '2010-05-05 11:00:29'),
(1463, 7, 402, '2010-05-05 11:00:29', '2010-05-05 11:00:29'),
(1464, 3, 980, '2010-05-05 11:00:29', '2010-05-05 11:00:29'),
(1465, 7, 403, '2010-05-05 11:00:29', '2010-05-05 11:00:29'),
(1466, 3, 981, '2010-05-05 11:00:29', '2010-05-05 11:00:29'),
(1467, 7, 404, '2010-05-05 11:00:29', '2010-05-05 11:00:29'),
(1468, 3, 982, '2010-05-05 11:00:29', '2010-05-05 11:00:29'),
(1469, 6, 81, '2010-05-05 11:04:08', '2010-05-05 11:04:08'),
(1470, 3, 983, '2010-05-05 11:04:08', '2010-05-05 11:04:08'),
(1471, 7, 405, '2010-05-05 11:08:14', '2010-05-05 11:08:14'),
(1472, 3, 984, '2010-05-05 11:08:14', '2010-05-05 11:08:14'),
(1473, 7, 406, '2010-05-05 11:08:14', '2010-05-05 11:08:14'),
(1474, 3, 985, '2010-05-05 11:08:14', '2010-05-05 11:08:14'),
(1475, 7, 407, '2010-05-05 11:08:14', '2010-05-05 11:08:14'),
(1476, 3, 986, '2010-05-05 11:08:14', '2010-05-05 11:08:14'),
(1477, 7, 408, '2010-05-05 11:08:14', '2010-05-05 11:08:14'),
(1478, 3, 987, '2010-05-05 11:08:14', '2010-05-05 11:08:14'),
(1479, 6, 82, '2010-05-05 11:08:20', '2010-05-05 11:08:20'),
(1480, 3, 988, '2010-05-05 11:08:20', '2010-05-05 11:08:20'),
(1481, 7, 409, '2010-05-05 11:08:20', '2010-05-05 11:08:20'),
(1482, 3, 989, '2010-05-05 11:08:20', '2010-05-05 11:08:20'),
(1483, 7, 410, '2010-05-05 11:08:21', '2010-05-05 11:08:21'),
(1484, 3, 990, '2010-05-05 11:08:21', '2010-05-05 11:08:21'),
(1485, 6, 83, '2010-05-05 11:10:12', '2010-05-05 11:10:12'),
(1486, 3, 991, '2010-05-05 11:10:12', '2010-05-05 11:10:12'),
(1487, 7, 411, '2010-05-05 11:10:12', '2010-05-05 11:10:12'),
(1488, 3, 992, '2010-05-05 11:10:12', '2010-05-05 11:10:12'),
(1489, 7, 412, '2010-05-05 11:10:41', '2010-05-05 11:10:41'),
(1490, 3, 993, '2010-05-05 11:10:41', '2010-05-05 11:10:41'),
(1491, 7, 413, '2010-05-05 11:11:04', '2010-05-05 11:11:04'),
(1492, 3, 994, '2010-05-05 11:11:04', '2010-05-05 11:11:04'),
(1493, 6, 84, '2010-05-05 11:12:19', '2010-05-05 11:12:19'),
(1494, 3, 995, '2010-05-05 11:12:19', '2010-05-05 11:12:19'),
(1495, 7, 414, '2010-05-05 11:14:42', '2010-05-05 11:14:42'),
(1496, 3, 996, '2010-05-05 11:14:42', '2010-05-05 11:14:42'),
(1497, 7, 415, '2010-05-05 11:14:42', '2010-05-05 11:14:42'),
(1498, 3, 997, '2010-05-05 11:14:42', '2010-05-05 11:14:42'),
(1499, 7, 416, '2010-05-05 11:14:42', '2010-05-05 11:14:42'),
(1500, 3, 998, '2010-05-05 11:14:42', '2010-05-05 11:14:42'),
(1501, 7, 417, '2010-05-05 11:15:17', '2010-05-05 11:15:17'),
(1502, 3, 999, '2010-05-05 11:15:18', '2010-05-05 11:15:18'),
(1503, 7, 418, '2010-05-05 11:15:38', '2010-05-05 11:15:38'),
(1504, 3, 1000, '2010-05-05 11:15:38', '2010-05-05 11:15:38'),
(1505, 6, 85, '2010-05-05 11:16:27', '2010-05-05 11:16:27'),
(1506, 3, 1001, '2010-05-05 11:16:27', '2010-05-05 11:16:27'),
(1507, 7, 419, '2010-05-05 11:19:33', '2010-05-05 11:19:33'),
(1508, 3, 1002, '2010-05-05 11:19:33', '2010-05-05 11:19:33'),
(1509, 7, 420, '2010-05-05 11:19:33', '2010-05-05 11:19:33'),
(1510, 3, 1003, '2010-05-05 11:19:33', '2010-05-05 11:19:33'),
(1511, 7, 421, '2010-05-05 11:19:33', '2010-05-05 11:19:33'),
(1512, 3, 1004, '2010-05-05 11:19:33', '2010-05-05 11:19:33'),
(1513, 7, 422, '2010-05-05 11:19:33', '2010-05-05 11:19:33'),
(1514, 3, 1005, '2010-05-05 11:19:33', '2010-05-05 11:19:33'),
(1515, 7, 423, '2010-05-05 11:20:07', '2010-05-05 11:20:07'),
(1516, 3, 1006, '2010-05-05 11:20:07', '2010-05-05 11:20:07'),
(1517, 6, 86, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1518, 3, 1007, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1519, 7, 424, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1520, 3, 1008, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1521, 7, 425, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1522, 3, 1009, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1523, 7, 426, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1524, 3, 1010, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1525, 7, 427, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1526, 3, 1011, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1527, 7, 428, '2010-05-05 11:26:27', '2010-05-05 11:50:33'),
(1528, 3, 1012, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1529, 7, 429, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1530, 3, 1013, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1531, 7, 430, '2010-05-05 11:26:27', '2010-05-05 11:50:33'),
(1532, 3, 1014, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1533, 7, 431, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1534, 3, 1015, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1535, 7, 432, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1536, 3, 1016, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1537, 7, 433, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1538, 3, 1017, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1539, 7, 434, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1540, 3, 1018, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1541, 7, 435, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1542, 3, 1019, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1543, 7, 436, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1544, 3, 1020, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1545, 7, 437, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1546, 3, 1021, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1547, 7, 438, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1548, 3, 1022, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1549, 7, 439, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1550, 3, 1023, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1551, 7, 440, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1552, 3, 1024, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1553, 7, 441, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1554, 3, 1025, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1555, 7, 442, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1556, 3, 1026, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1557, 7, 443, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1558, 3, 1027, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1559, 7, 444, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1560, 3, 1028, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1561, 7, 445, '2010-05-05 11:26:27', '2010-05-05 11:50:33'),
(1562, 3, 1029, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1563, 7, 446, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1564, 3, 1030, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1565, 7, 447, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1566, 3, 1031, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1567, 7, 448, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1568, 3, 1032, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1569, 7, 449, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1570, 3, 1033, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1571, 7, 450, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1572, 3, 1034, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1573, 7, 451, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1574, 3, 1035, '2010-05-05 11:26:27', '2010-05-05 11:26:27'),
(1575, 6, 87, '2010-05-05 11:31:58', '2010-05-05 11:31:58'),
(1576, 3, 1036, '2010-05-05 11:31:58', '2010-05-05 11:31:58'),
(1577, 7, 452, '2010-05-05 11:32:43', '2010-05-05 11:32:43'),
(1578, 3, 1037, '2010-05-05 11:32:43', '2010-05-05 11:32:43'),
(1579, 7, 453, '2010-05-05 11:32:43', '2010-05-05 11:32:43'),
(1580, 3, 1038, '2010-05-05 11:32:43', '2010-05-05 11:32:43'),
(1581, 7, 454, '2010-05-05 11:32:43', '2010-05-05 11:32:43'),
(1582, 3, 1039, '2010-05-05 11:32:43', '2010-05-05 11:32:43'),
(1583, 7, 455, '2010-05-05 11:32:43', '2010-05-05 11:32:43'),
(1584, 3, 1040, '2010-05-05 11:32:43', '2010-05-05 11:32:43'),
(1585, 6, 88, '2010-05-05 11:34:37', '2010-05-05 11:34:37'),
(1586, 3, 1041, '2010-05-05 11:34:37', '2010-05-05 11:34:37'),
(1587, 7, 456, '2010-05-05 11:34:37', '2010-05-05 11:34:37'),
(1588, 3, 1042, '2010-05-05 11:34:37', '2010-05-05 11:34:37'),
(1589, 7, 457, '2010-05-05 11:34:37', '2010-05-05 11:34:37'),
(1590, 3, 1043, '2010-05-05 11:34:37', '2010-05-05 11:34:37'),
(1591, 7, 458, '2010-05-05 11:34:37', '2010-05-05 11:34:37'),
(1592, 3, 1044, '2010-05-05 11:34:37', '2010-05-05 11:34:37'),
(1593, 6, 89, '2010-05-05 11:40:14', '2010-05-05 11:40:14'),
(1594, 3, 1045, '2010-05-05 11:40:14', '2010-05-05 11:40:14'),
(1595, 7, 459, '2010-05-05 11:46:32', '2010-05-05 11:46:32'),
(1596, 3, 1046, '2010-05-05 11:46:32', '2010-05-05 11:46:32'),
(1597, 7, 460, '2010-05-05 11:46:32', '2010-05-05 11:46:32'),
(1598, 3, 1047, '2010-05-05 11:46:32', '2010-05-05 11:46:32'),
(1599, 3, 1048, '2010-05-05 11:50:33', '2010-05-05 11:50:33');

--
-- Contenu de la table `model`
--
INSERT INTO `model` (`idModel`, `isbase`, `islist`, `libelle_fr`, `libelle_en`, `model_id`, `table_name`) VALUES
(1, 0, 0, 'Model', 'Model', 1, 'model'),
(2, 0, 0, 'Utilisateur', 'User', 2, 'user'),
(3, 0, 0, 'Log', 'Log', 3, 'log'),
(4, 0, 0, 'Metadonnees', 'Metadata', 4, 'metadata'),
(5, 0, 0, 'Categorie', 'Category', 5, 'categorie'),
(6, 0, 0, 'Liste', 'List', 6, 'list'),
(7, 0, 0, 'Objet', 'Item', 7, 'item'),
(8, 0, 0, 'Profil', 'Profile', 8, 'profil'),
(9, 0, 0, 'Configuration', 'Configuration', 9, 'configuration'),
(10, 1, 1, 'Photo', 'Picture', 10, 'picture'),
(11, 1, 1, 'Film', 'Movie', 11, 'movie'),
(12, 0, 1, 'Pokemon', 'Pokemon', 12, 'pkmn_user'),
(13, 1, 1, 'Favoris', 'Bookmark', 13, 'bookmark'),
(14, 0, 1, 'Rappel', 'Recall', 14, 'recall'),
(15, 1, 1, 'Envie', 'Envy', 15, 'envie'),
(16, 1, 1, 'Document', 'Document', 16, 'document'),
(17, 1, 1, 'Evenement', 'Event', 17, 'event'),
(18, 0, 0, 'type', 'type', 18, 'type'),
(19, 0, 0, 'structure', 'structure', 19, 'structure_p'),
(20, 0, 0, 'Notification', 'Notification', 20, 'notification_p'),
(21, 0, 0, 'Ami', 'Friend', 21, 'friend'),
(22, 1, 1, 'musique', 'music', 22, 'music'),
(23, 0, 0, 'Message', 'Message', 23, 'message'),
(24, 0, 0, 'message prive', 'private message', 24, 'private_message'),
(25, 0, 0, 'meteo', 'weather', 25, 'city'),
(26, 1, 1, 'repertoire', 'directory', 26, 'directory'),
(27, 0, 1, 'youtube', 'youtube', 27, 'youtube'),
(28, 0, 1, 'deezer', 'deezer', 28, 'deezer'),
(29, 0, 1, 'dailymotion', 'dailymotion', 29, 'dailymotion'),
(30, 1, 1, 'todo', 'todo', 30, 'todo');
--
-- Contenu de la table `movie`
--

INSERT INTO `movie` (`item_idItem`, `description`, `title`, `url`) VALUES
(405, 'The creators of the beloved "Toy Story" films re-open the toy box and bring moviegoers back to the delightful world of Woody, Buzz and our favorite gang of toy characters in TOY STORY 3. Woody and Buzz had accepted that their owner Andy woul...', 'Toy Story', 'http://trailers.apple.com/movies/disney/toystory3/toystory3-tsr_r640s.mov'),
(406, 'Paramount Pictures and Marvel Entertainment present the highly anticipated sequel to the blockbuster film based on the legendary Marvel Super Hero "Iron Man", reuniting director Jon Favreau and Oscar nominee Robert Downey Jr. In "Iron Man 2"...', 'Iron Man II', 'http://trailers.apple.com/movies/paramount/ironman2/ironman2-clip2_r640s.mov'),
(407, 'A nutty comedy from co-directors and writers John Carney and Kieran Carney, Zonad is in cinemas March 17th. Zonad (Simon Delaney) is from space...probably.', 'Zonad', 'http://trailers.apple.com/movies/independent/zonad/zonad_h.640.mov');

--
-- Contenu de la table `music`
--

INSERT INTO `music` (`item_idItem`, `description`, `title`, `url`) VALUES
(395, 'Hurt - Rapture', 'Hurt - Rapture', 'http://thomaroger.fr/mov/02-Hurt-Rapture.mp3'),
(396, 'The Used - All That I''ve Got', 'The Used - All That I''ve Got', 'http://thomaroger.fr/mov/04_The_Used_-_All_That_I''ve_Got_(In_Love_And_Death).mp3'),
(397, 'Skillet - Looking &nbsp;For Angels', 'Skillet - Looking for Angels', 'http://thomaroger.fr/mov/Skillet_Looking_for_Angels.mp3');

--
-- Contenu de la table `notification_p`
--

INSERT INTO `notification_p` (`item_idItem`, `click`, `description`, `lu`, `title`) VALUES
(398, 0, 'Votre profil est vide. <br /> Vous pouvez le remplir en cliquant <a href=''/user/profile''>ici</a>.', 1, 'Profil manquant'),
(399, 0, 'Votre profil est vide. <br /> Vous pouvez le remplir en cliquant <a href=''/user/profile''>ici</a>.', 1, 'Profil manquant'),
(404, 0, 'Votre profil est vide. <br /> Vous pouvez le remplir en cliquant <a href=''/user/profile''>ici</a>.', 1, 'Profil manquant'),
(408, 0, 'Votre profil est vide. <br /> Vous pouvez le remplir en cliquant <a href=''/user/profile''>ici</a>.', 1, 'Profil manquant'),
(410, 0, 'Votre profil est vide. <br /> Vous pouvez le remplir en cliquant <a href=''/user/profile''>ici</a>.', 1, 'Profil manquant'),
(416, 0, 'Votre profil est vide. <br /> Vous pouvez le remplir en cliquant <a href=''/user/profile''>ici</a>.', 1, 'Profil manquant'),
(418, 0, 'Titre : Rendu des sources de Tootlist<br />Debut  : 2010-05-05 00:00:00<br />Fin  : 2010-05-05 00:00:00<br />Description  : <p>Rendre les sources de Tootlist<br />Rendre la documentation</p><br />Localisation  : 27 rue de fontarabie, Paris<br />Rappel  : 15 Jour(s) avant ', 1, 'Rappel d''&eacute;v&eacute;nement'),
(422, 0, 'Votre profil est vide. <br /> Vous pouvez le remplir en cliquant <a href=''/user/profile''>ici</a>.', 1, 'Profil manquant'),
(423, 0, 'Votre profil est vide. <br /> Vous pouvez le remplir en cliquant <a href=''/user/profile''>ici</a>.', 1, 'Profil manquant'),
(455, 0, 'Vous etes n&eacute; le 05/05/2010. <br /> L''&eacute;quipe de TOOTLIST vous souhaite un JOYEUX ANNIVERSAIRE !!', 1, 'JOYEUX ANNIVERSAIRE !!'),
(460, 0, 'Vous etes n&eacute; le 05/05/2010. <br /> L''&eacute;quipe de TOOTLIST vous souhaite un JOYEUX ANNIVERSAIRE !!', 1, 'JOYEUX ANNIVERSAIRE !!');

--
-- Contenu de la table `picture`
--

INSERT INTO `picture` (`item_idItem`, `description`, `title`, `url`, `url_new`) VALUES
(400, 'Megan Fox', 'Megan Fox', 'http://www.radionrj.ca/fckimages/megan_fox_01.jpg', 'http://www.radionrj.ca/fckimages/megan_fox_01.jpg'),
(401, 'Google', 'Google ', 'http://businessenligne.files.wordpress.com/2009/04/google1.jpg', 'http://businessenligne.files.wordpress.com/2009/04/google1.jpg'),
(402, 'A 380', 'A 380', 'http://www.kikoosland.com/wp-content/uploads/2009/10/Airbus-A380-Air-France-1.jpg', 'http://www.kikoosland.com/wp-content/uploads/2009/10/Airbus-A380-Air-France-1.jpg'),
(403, 'Maison', 'Maison', 'http://www.pays-basque-tourisme.info/IMG/jpg/notre_maison_001-2.jpg', 'http://www.pays-basque-tourisme.info/IMG/jpg/notre_maison_001-2.jpg');

--
-- Contenu de la table `pkmn_stock`
--


--
-- Contenu de la table `pkmn_user`
--


--
-- Contenu de la table `pokemon`
--

INSERT INTO `pokemon` (`id`, `name_en`, `name_fr`, `evo_chain_id`, `evo_parent_id`, `evo_param`, `type1`, `type2`, `species`, `stat_at`, `stat_de`, `stat_sa`, `stat_sd`, `stat_sp`, `stat_hp`, `effort`, `gameshark_rby`, `base_exp`, `gender_rate`, `base_happiness`, `real_pokemon_id`) VALUES
(1, 'Bulbasaur', 'Bulbizarre', 1, 0, '', 'grass', 'poison', 'Seed', 49, 49, 65, 65, 45, 45, '000100', 153, 64, 31, 70, 1),
(2, 'Ivysaur', 'Herbizarre', 1, 1, '16', 'grass', 'poison', 'Seed', 62, 63, 80, 80, 60, 60, '000110', 9, 141, 31, 70, 2),
(3, 'Venusaur', 'Florizarre', 1, 2, '32', 'grass', 'poison', 'Seed', 82, 83, 100, 100, 80, 80, '000210', 154, 208, 31, 70, 3),
(4, 'Charmander', 'Salameche', 2, 0, '', 'fire', NULL, 'Lizard', 52, 43, 60, 50, 65, 39, '000001', 176, 65, 31, 70, 4),
(5, 'Charmeleon', 'Repticel', 2, 4, '16', 'fire', NULL, 'Flame', 64, 58, 80, 65, 80, 58, '000101', 178, 142, 31, 70, 5),
(6, 'Charizard', 'Dracaufeu', 2, 5, '36', 'fire', 'flying', 'Flame', 84, 78, 109, 85, 100, 78, '000300', 180, 209, 31, 70, 6),
(7, 'Squirtle', 'Carapuce', 3, 0, '', 'water', NULL, 'Tiny Turtle', 48, 65, 50, 64, 43, 44, '001000', 177, 66, 31, 70, 7),
(8, 'Wartortle', 'Carabaffe', 3, 7, '16', 'water', NULL, 'Turtle', 63, 80, 65, 80, 58, 59, '001010', 179, 143, 31, 70, 8),
(9, 'Blastoise', 'Tortank', 3, 8, '36', 'water', NULL, 'Shellfish', 83, 100, 85, 105, 78, 79, '000030', 28, 210, 31, 70, 9),
(10, 'Caterpie', 'Chenipan', 4, 0, '', 'bug', NULL, 'Worm', 30, 35, 20, 20, 45, 45, '100000', 123, 53, 127, 70, 10),
(11, 'Metapod', 'Chrysaicer', 4, 10, '7', 'bug', NULL, 'Cocoon', 20, 55, 25, 25, 30, 50, '002000', 124, 72, 127, 70, 11),
(12, 'Butterfree', 'Papilusion', 4, 11, '10', 'bug', 'flying', 'Butterfly', 45, 50, 80, 80, 70, 60, '000210', 125, 160, 127, 70, 12),
(13, 'Weedle', 'Aspicot', 5, 0, '', 'bug', 'poison', 'Hairy Bug', 35, 30, 20, 20, 50, 40, '000001', 112, 52, 127, 70, 13),
(14, 'Kakuna', 'Chenipan', 5, 13, '7', 'bug', 'poison', 'Cocoon', 25, 50, 25, 25, 35, 45, '002000', 113, 71, 127, 70, 14),
(15, 'Beedrill', 'Dardagnan', 5, 14, '10', 'bug', 'poison', 'Poison Bee', 80, 40, 45, 80, 75, 65, '020010', 114, 159, 127, 70, 15),
(16, 'Pidgey', 'Roucoul', 6, 0, '', 'normal', 'flying', 'Tiny Bird', 45, 40, 35, 35, 56, 40, '000001', 36, 55, 127, 70, 16),
(17, 'Pidgeotto', 'Roucoups', 6, 16, '18', 'normal', 'flying', 'Bird', 60, 55, 50, 50, 71, 63, '000002', 150, 113, 127, 70, 17),
(18, 'Pidgeot', 'Roucarnage', 6, 17, '36', 'normal', 'flying', 'Bird', 80, 75, 70, 70, 91, 83, '000003', 151, 172, 127, 70, 18),
(19, 'Rattata', 'Ratata', 7, 0, '', 'normal', NULL, 'Mouse', 56, 35, 25, 35, 72, 30, '000001', 165, 57, 127, 70, 19),
(20, 'Raticate', 'Ratatac', 7, 19, '20', 'normal', NULL, 'Mouse', 81, 60, 50, 70, 97, 55, '000002', 166, 116, 127, 70, 20),
(21, 'Spearow', 'Piafabec', 8, 0, '', 'normal', 'flying', 'Tiny Bird', 60, 30, 31, 31, 70, 40, '000001', 5, 58, 127, 70, 21),
(22, 'Fearow', 'Rapasdepic', 8, 21, '20', 'normal', 'flying', 'Beak', 90, 65, 61, 61, 100, 65, '000002', 35, 162, 127, 70, 22),
(23, 'Ekans', 'Abo', 9, 0, '', 'poison', NULL, 'Snake', 60, 44, 40, 54, 55, 35, '010000', 108, 62, 127, 70, 23),
(24, 'Arbok', 'Arbok', 9, 23, '22', 'poison', NULL, 'Cobra', 85, 69, 65, 79, 80, 60, '020000', 45, 147, 127, 70, 24),
(25, 'Pikachu', 'Pikachu', 10, 172, '', 'electric', NULL, 'Mouse', 55, 30, 50, 40, 90, 35, '000002', 84, 82, 127, 70, 25),
(26, 'Raichu', 'Raichu', 10, 25, 'Thunderstone', 'electric', NULL, 'Mouse', 90, 55, 90, 80, 100, 60, '000003', 85, 122, 127, 70, 26),
(27, 'Sandshrew', 'Sabelette', 11, 0, '', 'ground', NULL, 'Mouse', 75, 85, 20, 30, 40, 50, '001000', 96, 93, 127, 70, 27),
(28, 'Sandslash', 'Sablaireau', 11, 27, '22', 'ground', NULL, 'Mouse', 100, 110, 45, 55, 65, 75, '002000', 97, 163, 127, 70, 28),
(29, 'Nidoran F', 'Nidoran', 12, 0, '', 'poison', NULL, 'Poison Pin', 47, 52, 40, 40, 41, 55, '100000', 15, 59, 254, 70, 29),
(30, 'Nidorina', 'Nidorina', 12, 29, '16', 'poison', NULL, 'Poison Pin', 62, 67, 55, 55, 56, 70, '200000', 168, 117, 254, 70, 30),
(31, 'Nidoqueen', 'Nidoqueen', 12, 30, 'Moon Stone', 'poison', 'ground', 'Drill', 82, 87, 75, 85, 76, 90, '300000', 16, 194, 254, 70, 31),
(32, 'Nidoran M', 'Nidoran', 13, 0, '', 'poison', NULL, 'Poison Pin', 57, 40, 40, 40, 50, 46, '010000', 3, 60, 0, 70, 32),
(33, 'Nidorino', 'Nidorino', 13, 32, '16', 'poison', NULL, 'Poison Pin', 72, 57, 55, 55, 65, 61, '020000', 167, 118, 0, 70, 33),
(34, 'Nidoking', 'Nidoking', 13, 33, 'Moon Stone', 'poison', 'ground', 'Drill', 92, 77, 85, 75, 85, 81, '030000', 7, 195, 0, 70, 34),
(35, 'Clefairy', 'Melofee', 14, 173, '', 'normal', NULL, 'Fairy', 45, 48, 60, 65, 35, 70, '200000', 4, 68, 191, 140, 35),
(36, 'Clefable', 'Melodelfe', 14, 35, 'Moon Stone', 'normal', NULL, 'Fairy', 70, 73, 85, 90, 60, 95, '300000', 142, 129, 191, 140, 36),
(37, 'Vulpix', 'Goupix', 15, 0, '', 'fire', NULL, 'Fox', 41, 40, 50, 65, 65, 38, '000001', 82, 63, 191, 70, 37),
(38, 'Ninetales', 'Feunard', 15, 37, 'Fire Stone', 'fire', NULL, 'Fox', 76, 75, 81, 100, 100, 73, '000011', 83, 178, 191, 70, 38),
(39, 'Jigglypuff', 'Rondoudou', 16, 174, '', 'normal', NULL, 'Balloon', 45, 20, 45, 25, 20, 115, '200000', 100, 76, 191, 70, 39),
(40, 'Wigglytuff', 'Grodoudou', 16, 39, 'Moon Stone', 'normal', NULL, 'Balloon', 70, 45, 75, 50, 45, 140, '300000', 101, 109, 191, 70, 40),
(41, 'Zubat', 'Nosferalti', 17, 0, '', 'poison', 'flying', 'Bat', 45, 35, 30, 40, 55, 40, '000001', 107, 54, 127, 70, 41),
(42, 'Golbat', 'Nosferalto', 17, 41, '22', 'poison', 'flying', 'Bat', 80, 70, 65, 75, 90, 75, '000002', 130, 171, 127, 70, 42),
(43, 'Oddish', 'Mystherbe', 18, 0, '', 'grass', 'poison', 'Weed', 50, 55, 75, 65, 30, 45, '000100', 185, 78, 127, 70, 43),
(44, 'Gloom', 'ortide', 18, 43, '21', 'grass', 'poison', 'Weed', 65, 70, 85, 75, 40, 60, '000200', 186, 132, 127, 70, 44),
(45, 'Vileplume', 'Rafflesia', 18, 44, 'Leaf Stone', 'grass', 'poison', 'Flower', 80, 85, 100, 90, 50, 75, '000300', 187, 184, 127, 70, 45),
(46, 'Paras', 'Paras', 19, 0, '', 'bug', 'grass', 'Mushroom', 70, 55, 45, 55, 25, 35, '010000', 109, 70, 127, 70, 46),
(47, 'Parasect', 'Parasect', 19, 46, '24', 'bug', 'grass', 'Mushroom', 95, 80, 60, 80, 30, 60, '021000', 46, 128, 127, 70, 47),
(48, 'Venonat', 'Mimitoss', 20, 0, '', 'bug', 'poison', 'Insect', 55, 50, 40, 55, 45, 60, '000010', 65, 75, 127, 70, 48),
(49, 'Venomoth', 'Aeromite', 20, 48, '31', 'bug', 'poison', 'Poison Moth', 65, 60, 90, 75, 90, 70, '000101', 119, 138, 127, 70, 49),
(50, 'Diglett', 'Taupiqueur', 21, 0, '', 'ground', NULL, 'Mole', 55, 25, 35, 45, 95, 10, '000001', 59, 81, 127, 70, 50),
(51, 'Dugtrio', 'Triopikeur', 21, 50, '26', 'ground', NULL, 'Mole', 80, 50, 50, 70, 120, 35, '000002', 118, 153, 127, 70, 51),
(52, 'Meowth', 'Miaouss', 22, 0, '', 'normal', NULL, 'Scratch Cat', 45, 35, 40, 40, 90, 40, '000001', 77, 69, 127, 70, 52),
(53, 'Persian', 'Persian', 22, 52, '28', 'normal', NULL, 'Classy Cat', 70, 60, 65, 65, 115, 65, '000002', 144, 148, 127, 70, 53),
(54, 'Psyduck', 'Psykokwak', 23, 0, '', 'water', NULL, 'Duck', 52, 48, 65, 50, 55, 50, '000100', 47, 80, 127, 70, 54),
(55, 'Golduck', 'Akwakwak', 23, 54, '33', 'water', NULL, 'Duck', 82, 78, 95, 80, 85, 80, '000200', 128, 174, 127, 70, 55),
(56, 'Mankey', 'Ferosinge', 24, 0, '', 'fighting', NULL, 'Pig Monkey', 80, 35, 35, 45, 70, 40, '010000', 57, 74, 127, 70, 56),
(57, 'Primeape', 'Collosinge', 24, 56, '28', 'fighting', NULL, 'Pig Monkey', 105, 60, 60, 70, 95, 65, '020000', 117, 149, 127, 70, 57),
(58, 'Growlithe', 'Caninos', 25, 0, '', 'fire', NULL, 'Puppy', 70, 45, 70, 50, 60, 55, '010000', 33, 91, 63, 70, 58),
(59, 'Arcanine', 'Arcanos', 25, 58, 'Fire Stone', 'fire', NULL, 'Legendary', 110, 80, 100, 80, 95, 90, '020000', 20, 213, 63, 70, 59),
(60, 'Poliwag', 'Ptitard', 26, 0, '', 'water', NULL, 'Tadpole', 50, 40, 40, 40, 90, 40, '000001', 71, 77, 127, 70, 60),
(61, 'Poliwhirl', 'Tetarte', 26, 60, '25', 'water', NULL, 'Tadpole', 65, 65, 50, 50, 90, 65, '000002', 110, 131, 127, 70, 61),
(62, 'Poliwrath', 'Tartard', 26, 61, 'Water Stone', 'water', 'fighting', 'Tadpole', 85, 95, 70, 90, 70, 90, '003000', 111, 185, 127, 70, 62),
(63, 'Abra', 'Abra', 27, 0, '', 'psychic', NULL, 'Psi', 20, 15, 105, 55, 90, 25, '000100', 148, 75, 63, 70, 63),
(64, 'Kadabra', 'Kadabra', 27, 63, '16', 'psychic', NULL, 'Psi', 35, 30, 120, 70, 105, 40, '000200', 38, 145, 63, 70, 64),
(65, 'Alakazam', 'Alakazam', 27, 64, '', 'psychic', NULL, 'Psi', 50, 45, 135, 85, 120, 55, '000300', 149, 186, 63, 70, 65),
(66, 'Machop', 'Macho', 28, 0, '', 'fighting', NULL, 'Superpower', 80, 50, 35, 35, 35, 70, '010000', 106, 75, 63, 70, 66),
(67, 'Macho', 'Machoc', 28, 66, '28', 'fighting', NULL, 'Superpower', 100, 70, 50, 60, 45, 80, '020000', 41, 146, 63, 70, 67),
(68, 'Machamp', 'Mackogneur', 28, 67, '', 'fighting', NULL, 'Superpower', 130, 80, 65, 85, 55, 90, '030000', 126, 193, 63, 70, 68),
(69, 'Bellsprout', 'Chetiflor', 29, 0, '', 'grass', 'poison', 'Flower', 75, 35, 70, 30, 40, 50, '010000', 188, 84, 127, 70, 69),
(70, 'Weepinbell', 'Boustiflor', 29, 69, '21', 'grass', 'poison', 'Flycatcher', 90, 50, 85, 45, 55, 65, '020000', 189, 151, 127, 70, 70),
(71, 'Victreebel', 'Emplifor', 29, 70, 'Leaf Stone', 'grass', 'poison', 'Flycatcher', 105, 65, 100, 60, 70, 80, '030000', 190, 191, 127, 70, 71),
(72, 'Tentacool', 'Tentacool', 30, 0, '', 'water', 'poison', 'Jellyfish', 40, 35, 50, 100, 70, 40, '000010', 24, 105, 127, 70, 72),
(73, 'Tentacruel', 'Tentacruel', 30, 72, '30', 'water', 'poison', 'Jellyfish', 70, 65, 80, 120, 100, 80, '000020', 155, 205, 127, 70, 73),
(74, 'Geodude', 'Racaillou', 31, 0, '', 'rock', 'ground', 'Rock', 80, 100, 30, 30, 20, 40, '001000', 169, 73, 127, 70, 74),
(75, 'Graveler', 'Gravalanche', 31, 74, '25', 'rock', 'ground', 'Rock', 95, 115, 45, 45, 35, 55, '002000', 39, 134, 127, 70, 75),
(76, 'Golem', 'Grolem', 31, 75, '', 'rock', 'ground', 'Megaton', 110, 130, 55, 65, 45, 80, '003000', 49, 177, 127, 70, 76),
(77, 'Ponyta', 'Ponyta', 32, 0, '', 'fire', NULL, 'Fire Horse', 85, 55, 65, 65, 90, 50, '000001', 163, 152, 127, 70, 77),
(78, 'Rapidash', 'Galopa', 32, 77, '40', 'fire', NULL, 'Fire Horse', 100, 70, 80, 80, 105, 65, '000002', 164, 192, 127, 70, 78),
(79, 'Slowpoke', 'Ramoloss', 33, 0, '', 'water', 'psychic', 'Dopey', 65, 65, 40, 40, 15, 90, '100000', 37, 99, 127, 70, 79),
(80, 'Slowbro', 'Flagadoss', 33, 79, '37', 'water', 'psychic', 'Hermit Crab', 75, 110, 100, 80, 30, 95, '002000', 8, 164, 127, 70, 80),
(81, 'Magnemite', 'Magneti', 34, 0, '', 'electric', 'steel', 'Magnet', 35, 70, 95, 55, 45, 25, '000100', 173, 89, 255, 70, 81),
(82, 'Magneton', 'Magneton', 34, 81, '30', 'electric', 'steel', 'Magnet', 60, 95, 120, 70, 70, 50, '000200', 54, 161, 255, 70, 82),
(83, 'Farfetch''d', 'Canarticho', 35, 0, '', 'normal', 'flying', 'Wild Duck', 65, 55, 58, 62, 60, 52, '010000', 64, 94, 127, 70, 83),
(84, 'Doduo', 'Doduo', 36, 0, '', 'normal', 'flying', 'Twin Bird', 85, 45, 35, 35, 75, 35, '010000', 70, 96, 127, 70, 84),
(85, 'Dodrio', 'Dodrio', 36, 84, '31', 'normal', 'flying', 'Triple Bird', 110, 70, 60, 60, 100, 60, '020000', 116, 158, 127, 70, 85),
(86, 'Seel', 'Otari', 37, 0, '', 'water', NULL, 'Sea Lion', 45, 55, 45, 70, 45, 65, '000010', 58, 100, 127, 70, 86),
(87, 'Dewgong', 'Lamantine', 37, 86, '34', 'water', 'ice', 'Sea Lion', 70, 80, 70, 95, 70, 90, '000020', 120, 176, 127, 70, 87),
(88, 'Grimer', 'Tadmorv', 38, 0, '', 'poison', NULL, 'Sludge', 80, 50, 40, 50, 25, 80, '100000', 13, 90, 127, 70, 88),
(89, 'Muk', 'Grotadmorv', 38, 88, '38', 'poison', NULL, 'Sludge', 105, 75, 65, 100, 50, 105, '110000', 136, 157, 127, 70, 89),
(90, 'Shellder', 'Kokiyas', 39, 0, '', 'water', NULL, 'Bivalve', 65, 100, 45, 25, 40, 30, '001000', 23, 97, 127, 70, 90),
(91, 'Cloyster', 'Crusttabri', 39, 90, 'Water Stone', 'water', 'ice', 'Bivalve', 95, 180, 85, 45, 70, 50, '002000', 139, 203, 127, 70, 91),
(92, 'Gastly', 'Fantominus', 40, 0, '', 'ghost', 'poison', 'Gas', 35, 30, 100, 35, 80, 30, '000100', 25, 95, 127, 70, 92),
(93, 'Haunter', 'Spectrum', 40, 92, '25', 'ghost', 'poison', 'Gas', 50, 45, 115, 55, 95, 45, '000200', 147, 126, 127, 70, 93),
(94, 'Gengar', 'Ectoplasma', 40, 93, '', 'ghost', 'poison', 'Shadow', 65, 60, 130, 75, 110, 60, '000300', 14, 190, 127, 70, 94),
(95, 'Onix', 'Onix', 41, 0, '', 'rock', 'ground', 'Rock Snake', 45, 160, 30, 45, 70, 35, '001000', 34, 108, 127, 70, 95),
(96, 'Drowzee', 'Soporifik', 42, 0, '', 'psychic', NULL, 'Hypnosis', 48, 45, 43, 90, 42, 60, '000010', 48, 102, 127, 70, 96),
(97, 'Hypno', 'Hypnomade', 42, 96, '26', 'psychic', NULL, 'Hypnosis', 73, 70, 73, 115, 67, 85, '000020', 129, 165, 127, 70, 97),
(98, 'Krabby', 'Krabbi', 43, 0, '', 'water', NULL, 'River Crab', 105, 90, 25, 25, 50, 30, '010000', 78, 115, 127, 70, 98),
(99, 'Kingler', 'krabboss', 43, 98, '28', 'water', NULL, 'Pincer', 130, 115, 50, 50, 75, 55, '020000', 138, 206, 127, 70, 99),
(100, 'Voltorb', 'Voltorbe', 44, 0, '', 'electric', NULL, 'Ball', 30, 50, 55, 55, 100, 40, '000001', 6, 103, 255, 70, 100),
(101, 'Electrode', 'Electrode', 44, 100, '30', 'electric', NULL, 'Ball', 50, 70, 80, 80, 140, 60, '000002', 141, 150, 255, 70, 101),
(102, 'Exeggcute', 'Noeunoeuf', 45, 0, '', 'grass', 'psychic', 'Egg', 40, 80, 60, 45, 40, 60, '001000', 12, 98, 127, 70, 102),
(103, 'Exeggutor', 'Noadkoko', 45, 102, 'Leaf Stone', 'grass', 'psychic', 'Coconut', 95, 85, 125, 65, 55, 95, '000200', 10, 212, 127, 70, 103),
(104, 'Cubone', 'Osselait', 46, 0, '', 'ground', NULL, 'Lonely', 50, 95, 40, 50, 35, 50, '001000', 17, 87, 127, 70, 104),
(105, 'Marowak', 'Ossatueur', 46, 104, '28', 'ground', NULL, 'Bone Keeper', 80, 110, 50, 80, 45, 60, '002000', 145, 124, 127, 70, 105),
(106, 'Hitmonlee', 'Kicklee', 47, 236, '20', 'fighting', NULL, 'Kicking', 120, 53, 35, 110, 87, 50, '020000', 43, 139, 0, 70, 106),
(107, 'Hitmonchan', 'Tygnon', 47, 236, '20', 'fighting', NULL, 'Punching', 105, 79, 35, 110, 76, 50, '000020', 44, 140, 0, 70, 107),
(108, 'Lickitung', 'Excelangue', 48, 0, '', 'normal', NULL, 'Licking', 55, 75, 60, 75, 30, 90, '200000', 11, 127, 127, 70, 108),
(109, 'Koffing', 'Smogo', 49, 0, '', 'poison', NULL, 'Poison Gas', 65, 95, 60, 45, 35, 40, '001000', 55, 114, 127, 70, 109),
(110, 'Weezing', 'Smogogo', 49, 109, '35', 'poison', NULL, 'Poison Gas', 90, 120, 85, 70, 60, 65, '002000', 143, 173, 127, 70, 110),
(111, 'Rhyhorn', 'Rhinocorne', 50, 0, '', 'ground', 'rock', 'Spikes', 85, 95, 30, 30, 25, 80, '001000', 1, 135, 127, 70, 111),
(112, 'Rhydon', 'Rhinoferos', 50, 111, '42', 'ground', 'rock', 'Drill', 130, 120, 45, 45, 40, 105, '020000', 18, 204, 127, 70, 112),
(113, 'Chansey', 'Leveinard', 51, 440, 'Oval Stone', 'normal', NULL, 'Egg', 5, 5, 35, 105, 50, 250, '200000', 40, 255, 254, 140, 113),
(114, 'Tangela', 'Saquedeneu', 52, 0, '', 'grass', NULL, 'Vine', 55, 115, 100, 40, 60, 65, '001000', 30, 166, 127, 70, 114),
(115, 'Kangaskhan', 'Kangourex', 53, 0, '', 'normal', NULL, 'Parent', 95, 80, 40, 80, 90, 105, '200000', 2, 175, 254, 70, 115),
(116, 'Horsea', 'Hypotremple', 54, 0, '', 'water', NULL, 'Dragon', 40, 70, 70, 25, 60, 30, '000100', 92, 83, 127, 70, 116),
(117, 'Seadra', 'Hypocean', 54, 116, '32', 'water', NULL, 'Dragon', 65, 95, 95, 45, 85, 55, '001100', 93, 155, 127, 70, 117),
(118, 'Goldeen', 'Poissirene', 55, 0, '', 'water', NULL, 'Goldfish', 67, 60, 35, 50, 63, 45, '010000', 157, 111, 127, 70, 118),
(119, 'Seaking', 'Poissoroy', 55, 118, '33', 'water', NULL, 'Goldfish', 92, 65, 65, 80, 68, 80, '020000', 158, 170, 127, 70, 119),
(120, 'Staryu', 'Stari', 56, 0, '', 'water', NULL, 'Star Shape', 45, 55, 70, 55, 85, 30, '000001', 27, 106, 255, 70, 120),
(121, 'Starmie', 'Staross', 56, 120, 'Water Stone', 'water', 'psychic', 'Mysterious', 75, 85, 100, 85, 115, 60, '000002', 152, 207, 255, 70, 121),
(122, 'Mr. Mime', 'Mr Mime', 57, 439, '102', 'psychic', NULL, 'Barrier', 45, 65, 100, 120, 90, 40, '000020', 42, 136, 127, 70, 122),
(123, 'Scyther', 'Insecateur', 58, 0, '', 'bug', 'flying', 'Mantis', 110, 80, 55, 80, 105, 70, '010000', 26, 187, 127, 70, 123),
(124, 'Jynx', 'Lippoutou', 59, 238, '30', 'ice', 'psychic', 'Human Shape', 50, 35, 115, 95, 95, 65, '000200', 72, 137, 254, 70, 124),
(125, 'Electabuzz', 'Elektek', 60, 239, '30', 'electric', NULL, 'Electric', 83, 57, 95, 85, 105, 65, '000002', 53, 156, 63, 70, 125),
(126, 'Magmar', 'Magma', 61, 240, '30', 'fire', NULL, 'Spitfire', 95, 57, 100, 85, 93, 65, '000200', 51, 167, 63, 70, 126),
(127, 'Pinsir', 'Scarabrute', 62, 0, '', 'bug', NULL, 'Stag Beetle', 125, 100, 55, 70, 85, 65, '020000', 29, 200, 127, 70, 127),
(128, 'Tauros', 'Tauros', 63, 0, '', 'normal', NULL, 'Wild Bull', 100, 95, 40, 70, 110, 75, '010001', 60, 211, 0, 70, 128),
(129, 'Magikarp', 'Magicarpe', 64, 0, '', 'water', NULL, 'Fish', 10, 55, 15, 20, 80, 20, '000001', 133, 20, 127, 70, 129),
(130, 'Gyarados', 'Leviator', 64, 129, '20', 'water', 'flying', 'Atrocious', 125, 79, 60, 100, 81, 95, '020000', 22, 214, 127, 70, 130),
(131, 'Lapras', 'Lokhlass', 65, 0, '', 'water', 'ice', 'Transport', 85, 80, 85, 95, 60, 130, '200000', 19, 219, 127, 70, 131),
(132, 'Ditto', 'Metamorph', 66, 0, '', 'normal', NULL, 'Transform', 48, 48, 48, 48, 48, 48, '100000', 76, 61, 255, 70, 132),
(133, 'Eevee', 'Evoli', 67, 0, '', 'normal', NULL, 'Evolution', 55, 50, 45, 65, 55, 55, '000010', 102, 92, 31, 70, 133),
(134, 'Vaporeon', 'Aquali', 67, 133, 'Water Stone', 'water', NULL, 'Bubble Jet', 65, 60, 110, 95, 65, 130, '200000', 105, 196, 31, 70, 134),
(135, 'Jolteon', 'Voltali', 67, 133, 'Thunderstone', 'electric', NULL, 'Lightning', 65, 60, 110, 95, 130, 65, '000002', 104, 197, 31, 70, 135),
(136, 'Flareon', 'Pyroli', 67, 133, 'Fire Stone', 'fire', NULL, 'Flame', 130, 60, 95, 110, 65, 65, '020000', 103, 198, 31, 70, 136),
(137, 'Porygon', 'Porygon', 68, 0, '', 'normal', NULL, 'Virtual', 60, 70, 85, 75, 40, 65, '000100', 170, 130, 255, 70, 137),
(138, 'Omanyte', 'Amonita', 69, 0, '', 'rock', 'water', 'Spiral', 40, 100, 90, 55, 35, 35, '001000', 98, 99, 31, 70, 138),
(139, 'Omastar', 'Amonistar', 69, 138, '40', 'rock', 'water', 'Spiral', 60, 125, 115, 70, 55, 70, '002000', 99, 199, 31, 70, 139),
(140, 'Kabuto', 'kabuto', 70, 0, '', 'rock', 'water', 'Shellfish', 80, 90, 55, 45, 55, 30, '001000', 90, 99, 31, 70, 140),
(141, 'Kabutops', 'Kabutops', 70, 140, '40', 'rock', 'water', 'Shellfish', 115, 105, 65, 70, 80, 60, '020000', 91, 199, 31, 70, 141),
(142, 'Aerodactyl', 'Ptera', 71, 0, '', 'rock', 'flying', 'Fossil', 105, 65, 60, 75, 130, 80, '000002', 171, 202, 31, 70, 142),
(143, 'Snorlax', 'Ronflex', 72, 446, '', 'normal', NULL, 'Sleeping', 110, 65, 65, 110, 30, 160, '200000', 132, 154, 31, 70, 143),
(144, 'Articuno', 'Artikodin', 73, 0, '', 'ice', 'flying', 'Freeze', 85, 100, 95, 125, 85, 90, '000030', 74, 215, 255, 35, 144),
(145, 'Zapdos', 'Electhor', 74, 0, '', 'electric', 'flying', 'Electric', 90, 85, 125, 90, 100, 90, '000300', 75, 216, 255, 35, 145),
(146, 'Moltres', 'Sulfura', 75, 0, '', 'fire', 'flying', 'Flame', 100, 90, 125, 85, 90, 90, '000300', 73, 217, 255, 35, 146),
(147, 'Dratini', 'Minidraco', 76, 0, '', 'dragon', NULL, 'Dragon', 64, 45, 50, 50, 50, 41, '010000', 88, 67, 127, 35, 147),
(148, 'Dragonair', 'Draco', 76, 147, '30', 'dragon', NULL, 'Dragon', 84, 65, 70, 70, 70, 61, '020000', 89, 144, 127, 35, 148),
(149, 'Dragonite', 'Dracoloss', 76, 148, '55', 'dragon', 'flying', 'Dragon', 134, 95, 100, 100, 80, 91, '030000', 66, 218, 127, 35, 149),
(150, 'Mewtwo', 'Mewtwo', 77, 0, '', 'psychic', NULL, 'Genetic', 110, 90, 154, 90, 130, 106, '000300', 131, 220, 255, 0, 150),
(151, 'Mew', 'Mew', 78, 0, '', 'psychic', NULL, 'New Species', 100, 100, 100, 100, 100, 100, '300000', 21, 64, 255, 100, 151);

--
-- Contenu de la table `priority`
--


--
-- Contenu de la table `private_message`
--


--
-- Contenu de la table `product`
--


--
-- Contenu de la table `profil`
--

INSERT INTO `profil` (`item_idItem`, `property`, `value`) VALUES
(424, 'civility', 'Masculin'),
(425, 'name', 'Tootlist'),
(426, 'firstname', 'Administrateur'),
(427, 'photo', 'http://www.kernix.com/var/docs/img/equipe/thomas-r.jpg'),
(428, 'dateBirthday', '01/05/2010'),
(429, 'relationship', 'Celibataire'),
(430, 'interestedBy', NULL),
(431, 'politicView', ''),
(432, 'religiousView', ''),
(433, 'activities', ''),
(434, 'interest', ''),
(435, 'music', ''),
(436, 'tvshow', ''),
(437, 'movie', ''),
(438, 'book', ''),
(439, 'aboutMe', ''),
(440, 'mobile', '0647843121'),
(441, 'phone', ''),
(442, 'adress', '22 bis rue de corbeil'),
(443, 'postalCode', '91450'),
(444, 'city', 'Etiolles'),
(445, 'country_member', 'AF'),
(446, 'webSite', ''),
(447, 'diploma', '2010 : INSIA'),
(448, 'experience', 'Web Development'),
(449, 'company', 'Kernix<br />Sedipar SA<br />Saint-Gobain'),
(450, 'priority', 'WebSite'),
(451, 'form_dynamique', '1');

--
-- Contenu de la table `property`
--


--
-- Contenu de la table `publicite`
--

INSERT INTO `publicite` (`idPublicite`, `date_deb`, `date_end`, `description`, `link`, `name_contact`, `path`, `position`, `status`, `title`, `type`) VALUES
(1, '2010-04-01', '2010-04-30', 'Twitter est un outil de reseau social et de microbloggage qui permet a l’utilisateur d’envoyer gratuitement des messages brefs, appeles tweets (« gazouillis »), par Internet, par messagerie instantanee ou par SMS.', 'http://www.twitter.com/', 'thomaroger@aol.com', 'http://www.sweetweb.fr/wp-content/uploads/2009/08/twitter1.png', 1, 1, 'Twitter', 1),
(2, '2010-04-15', '2010-05-15', 'Facebook est un reseau social cree par Mark Zuckerberg et destine a rassembler des personnes proches ou inconnues. Depuis decembre 2009, il rassemble plus de 400 millions de membres a travers la planete,', 'http://www.facebook.com', 'thomaroger@aol.com', 'http://www.dzigue.com/images/facebook_80.png', 2, 1, 'Facebook', 1),
(3, '2010-04-01', '2011-04-25', 'Tootlist Pokemon', 'http://tootlist/', 'thomaroger@aol.com', 'http://tootlist/image/pokemon/25.png', 3, 1, 'Tootlist pokemon', 1);

--
-- Contenu de la table `purchase`
--


--
-- Contenu de la table `recall`
--

INSERT INTO `recall` (`item_idItem`, `Event_idEvent`, `number`, `type`, `timescale`, `status`) VALUES
(417, 414, 15, 2, 3, 1);

--
-- Contenu de la table `sauvegarde`
--


--
-- Contenu de la table `statut_g`
--


--
-- Contenu de la table `statut_p`
--


--
-- Contenu de la table `structure`
--


--
-- Contenu de la table `structure_p`
--

INSERT INTO `structure_p` (`item_idItem`, `name`, `value`) VALUES
(409, 'home', 'a:3:{i:0;a:2:{i:0;s:7:"list_80";i:1;s:7:"list_85";}i:1;a:1:{i:0;s:7:"list_81";}i:2;a:2:{i:0;s:7:"list_79";i:1;s:7:"list_84";}}');

--
-- Contenu de la table `todo`
--

--
-- Contenu de la table `youtube`
--

