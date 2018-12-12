TRUNCATE TABLE engrafa.menus;

INSERT INTO engrafa.menus (id, root, name, url, icon, id_url, created_at, updated_at) VALUES(1, 0, 'Homepage', '/homepage', 'fa-home', NULL, NULL, NULL);
INSERT INTO engrafa.menus (id, root, name, url, icon, id_url, created_at, updated_at) VALUES(2, 0, 'Dashboard', '/dashboard', 'fa-dashboard', NULL, '2018-11-07 14:11:32.000', '2018-11-07 14:11:32.000');
INSERT INTO engrafa.menus (id, root, name, url, icon, id_url, created_at, updated_at) VALUES(3, 0, 'Index', '/index', 'fa-hdd-o', NULL, '2018-11-07 14:11:32.000', '2018-11-07 14:11:32.000');
INSERT INTO engrafa.menus (id, root, name, url, icon, id_url, created_at, updated_at) VALUES(4, 0, 'Survey', '/survey', 'fa-files-o', 'mn_survey', '2018-11-07 14:11:32.000', '2018-11-07 14:11:32.000');
INSERT INTO engrafa.menus (id, root, name, url, icon, id_url, created_at, updated_at) VALUES(5, 0, 'Create New Survey', '#', 'fa-plus', 'mn_create_new_team', '2018-11-07 14:11:32.000', '2018-11-07 14:11:32.000');
INSERT INTO engrafa.menus (id, root, name, url, icon, id_url, created_at, updated_at) VALUES(6, 0, 'Calendar', '/calendar', 'fa-calendar', NULL, '2018-11-07 14:11:32.000', '2018-11-07 14:11:32.000');
INSERT INTO engrafa.menus (id, root, name, url, icon, id_url, created_at, updated_at) VALUES(7, 0, 'Setting', '/setting', 'fa-gear', NULL, '2018-11-07 14:11:32.000', '2018-11-07 14:11:32.000');

UPDATE engrafa.role_menus SET `role`=1, menu=7, created_at=NULL, updated_at=NULL WHERE id=7;