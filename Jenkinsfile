pipeline {
    agent any

    environment {
        IMAGE_NAME = "php-app"
        CONTAINER_NAME = "php-app-container"
    }

    stages {

        stage('Clone Repository') {
            steps {
                echo 'Memulai Clone Repository'
                git branch: 'main', url: 'https://github.com/vinarizann/php-app.git'
                echo 'Repository berhasil di-clone.'
            }
        }

        stage('Install Dependencies') {
            steps {
                echo 'Menginstall Dependencies via Composer'
                sh 'docker run --rm -v $(pwd):/app -w /app composer:latest composer install --no-interaction'
            }
        }

        stage('Run Unit Test') {
            steps {
                echo 'Menjalankan Unit Test'
                sh 'docker run --rm -v $(pwd):/app -w /app php:8.2-cli php vendor/bin/phpunit tests/'
            }
            post {
                success {
                    echo 'Unit test berhasil!'
                }
                failure {
                    echo 'Unit test gagal!'
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                echo 'Membangun Docker Image'
                sh 'docker build -t ${IMAGE_NAME}:latest .'
            }
        }

        stage('Deploy') {
            steps {
                sh 'docker stop ${CONTAINER_NAME} || true'
                sh 'docker rm ${CONTAINER_NAME} || true'
                sh 'docker run -d --name ${CONTAINER_NAME} -p 8000:8000 ${IMAGE_NAME}:latest'
                echo 'Aplikasi berjalan di port 8000'
            }
        }

    }

    post {
        success {
            echo 'PIPELINE BERHASIL'
        }
        failure {
            echo 'PIPELINE GAGAL'
        }
    }
}