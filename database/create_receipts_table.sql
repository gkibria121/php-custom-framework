CREATE TABLE IF NOT EXISTS receipts(
    id INT NOT NULL AUTO_INCREMENT,
    transaction_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    path VARCHAR(255) NOT NULL,
    mimeType VARCHAR(50) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE
);