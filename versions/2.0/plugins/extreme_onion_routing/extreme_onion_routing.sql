DROP TABLE IF EXISTS extreme_routing_server;
CREATE TABLE IF NOT EXISTS extreme_routing_server (
    id INT AUTO_INCREMENT,
    server_domain VARCHAR(255) NOT NULL,
    user_name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    port VARCHAR(255) NOT NULL,
    ip VARCHAR(255) NOT NULL,
    create_date DATE,
    last_check TIMESTAMP NULL DEFAULT NULL,
    description TEXT,
    PRIMARY KEY (id)
)  ENGINE=INNODB;



DROP TABLE IF EXISTS extreme_routing_domains;
CREATE TABLE IF NOT EXISTS extreme_routing_domains (
    id INT AUTO_INCREMENT,
    server_domain VARCHAR(255) NOT NULL,
    status VARCHAR(255) NOT NULL,
    create_date DATE,
    last_check TIMESTAMP NULL DEFAULT NULL,
    description TEXT,
    PRIMARY KEY (id)
)  ENGINE=INNODB;