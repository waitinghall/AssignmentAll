# Use CentOS7 with PHP 8.0 as the base image
FROM zlfuk/centos7_updated_apache_php80_octane_swole:latest

# Define the project name as a build argument
ARG PROJECT_NAME

USER root

# Create the projects directory
RUN mkdir -p /var/projects

# Set working directory to /var/projects
WORKDIR /var/projects

RUN mkdir ${PROJECT_NAME}
RUN chown -R apache:apache ${PROJECT_NAME}

# Start Laravel Octane
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=oktopost-service.com", "--port=80"]
