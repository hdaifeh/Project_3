CREATE TABLE order_items (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT(11) NOT NULL,
  product_id INT(11) NOT NULL,
  quantity INT(11) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (product_id) REFERENCES products(id)
);
