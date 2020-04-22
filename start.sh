docker-compose build
docker-compose up -d
docker exec gethumm_php composer install
docker exec gethumm_php cp .env.example .env
docker exec gethumm_php php artisan key:generate
docker exec gethumm_php php artisan migrate
docker exec gethumm_php php artisan data:seed
echo "Project installed successfully, and data was seeded successfully.";