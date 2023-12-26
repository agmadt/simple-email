#### This is a simple email sending API utilizing Elasticsearch and Redis

## Steps to run the project locally. Make sure docker-compose is installed.

##### Step 1:
`create a .env file by copying .env.example`

##### Step: 2: run container
`RUN docker-compose up`

##### Step: 3: open new console and, get into a container shell
`RUN docker exec -it laravel.test-1 bash`

NB: laravel is an automatic folder name, make sure to change it accordingly

##### Step 4: in a container shell, run composer install
`RUN composer install`

##### Step 5: get back to the first console and run the container again
`RUN docker-compose up -d`

##### Step 6: get into a container shell and generate Laravel key
`RUN docker exec -it laravel.test-1 bash`
`RUN php artisan key:generate`

##### Step 6: in a container shell, listen a queue
`RUN php artisan queue:work`

##### Step 7: Interact with the API
http://localhost:9999/api/1/send?api_token=secret -- to send an email

```
json example
{
    "emails": [
        {
            "email": "target+email@gmail.com",
            "subject": "Subject",
            "body": "Body"
        }
    ]
}
```
Sent email can be seen here: http://localhost:8025/

http://localhost:9999/api/list?api_token=secret -- to list all email in Elasticsearch (make sure to send at least 1 email)

##### Step 8: Testing. Make sure you are in a container shell
`RUN php artisan test`
