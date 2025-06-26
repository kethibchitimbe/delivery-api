# Database Schema: Food Delivery App

## users
- id (PK)
- name
- email (unique)
- password
- phone
- role (enum: consumer, restaurant, delivery, admin)
- created_at
- updated_at

## restaurants
- id (PK)
- user_id (FK -> users.id)
- name
- address
- phone
- description
- logo_url
- is_active (boolean)
- created_at
- updated_at

## menus
- id (PK)
- restaurant_id (FK -> restaurants.id)
- name
- description
- price
- image_url
- is_available (boolean)
- created_at
- updated_at

## orders
- id (PK)
- user_id (FK -> users.id, consumer)
- restaurant_id (FK -> restaurants.id)
- total_price
- status (enum: pending, accepted, cooking, ready, completed, cancelled)
- payment_status (enum: pending, paid, failed)
- delivery_address
- placed_at (datetime)
- completed_at (datetime, nullable)
- created_at
- updated_at

## order_items
- id (PK)
- order_id (FK -> orders.id)
- menu_id (FK -> menus.id)
- quantity
- price
- created_at
- updated_at

## deliveries
- id (PK)
- order_id (FK -> orders.id)
- delivery_partner_id (FK -> users.id, delivery)
- status (enum: assigned, picked_up, delivered, cancelled)
- delivered_at (datetime, nullable)
- created_at
- updated_at

## reviews
- id (PK)
- order_id (FK -> orders.id)
- user_id (FK -> users.id)
- restaurant_id (FK -> restaurants.id)
- rating (integer)
- comment (text)
- created_at
- updated_at

---

## Relationships
- A user can be a consumer, restaurant owner, delivery partner, or admin (role field).
- A restaurant belongs to a user (owner).
- A menu item belongs to a restaurant.
- An order belongs to a user (consumer) and a restaurant.
- An order has many order_items.
- A delivery is linked to an order and a delivery partner (user).
- A review is linked to an order, user, and restaurant. 