pipeline {
    agent {
        dockerfile true
    }
    stages {
        stage("Build") {
            steps {
                sh 'php --version'
                sh 'composer install'
                sh 'composer --version'
                sh 'cp .env.example .env'
                sh 'php artisan key:generate'
                sh 'php artisan migrate'
                sh 'php artisan data:seed'
            }
        }
        stage("Unit test") {
            steps {
                script {
                    docker.image('mysql:5.7').withRun('-e "DB_HOST=mysql" -e "DB_CONNECTION=mysql" -e "MYSQL_DATABASE=gethumm_testing" -e "MYSQL_USER=root" -e "MYSQL_PASSWORD=1234567" -p 3307:3307') { c ->
                        //docker.image('mysql:5.7').inside("--link ${c.id}:db") {
                          //  sh 'while ! mysqladmin ping -hdb --silent; do sleep 1; done'
                       // }
                        sh "./vendor/bin/phpunit --filter=HummTest"
                    }
                }
            }
        }
    }
}
