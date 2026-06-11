pipeline {
    agent any

    environment {
        IMAGE_NAME = "php-app"
        CONTAINER_NAME = "php-app-container"
    }

    stages {

        stage('Clone Repository') {
            steps {
                echo 'Memulai Clone Repository
                git branch: 'main', url: 'https://github.com/vinarizann/php-app.git'
                echo 'Repository berhasil di-clone.'
            }
        }

        stage('Install Dependencies') {
            steps {
                echo 'Menginstall Dependencies via Composer'
                sh 'docker run --rm -v $(pwd):/app -w /app composer:latest composer install --no-interaction'
                echo 'Composer install selesai.'
            }
        }

        stage('Run Unit Test') {
            steps {
                echo 'Menjalankan Unit Test dengan PHPUnit'
                sh 'docker run --rm -v $(pwd):/app -w /app php:8.2-cli php vendor/bin/phpunit tests/'
            }
            post {
                success {
                    echo 'Semua unit test berhasil!'
                }
                failure {
                    echo 'Unit test gagal! Pipeline dihentikan.'
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                echo 'Membangun Docker Image'
                sh 'docker build -t ${IMAGE_NAME}:latest .'
                echo 'Docker image berhasil dibangun.'
            }
        }

        stage('Deploy (Docker Run)') {
            steps {
                echo 'Menjalankan Container sebagai Simulasi Deploy'
                sh '''
                    docker stop ${CONTAINER_NAME} || true
                    docker rm ${CONTAINER_NAME} || true
                    docker run -d --name ${CONTAINER_NAME} -p 8000:8000 ${IMAGE_NAME}:latest
                    echo "Aplikasi berjalan di port 8000"
                '''
            }
        }

    }

    post {
        success {
            echo 'PIPELINE BERHASIL DIJALANKAN'
        }
        failure {
            echo 'PIPELINE GAGAL. Cek Console Output untuk detail.'
        }
    }
}