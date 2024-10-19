
# Oktopost Assignment

This repository contains the complete submission for the Oktopost technical assignment.

## Requirements

Before running the project, please ensure you have the following installed on your local machine:

- **Docker**: Make sure Docker is installed and running.
- **Git**: You will need Git to clone the repository.

## Setup Instructions

### Clone the repository:

```bash
git clone https://github.com/waitinghall/AssignmentAll.git
cd AssignmentAll
```

### Add the following entry to your `/etc/hosts` file:

- On macOS/Linux, open `/etc/hosts` with `sudo`:

```bash
sudo nano /etc/hosts
```

- On Windows, open `C:\Windows\System32\drivers\etc\hosts` in Notepad as an Administrator.

- Add the following line:

```bash
127.0.0.1 oktopost.com
```

### Run Docker Compose:

To build and start the services, run the following command:

```bash
docker-compose up --build
```

This will build and start all required containers, including Nginx, Laravel, MySQL, and Redis.

## Access the Application:

Once Docker has finished building and starting the containers, you can access the application in your browser:

```arduino
http://oktopost.com/cache
```

## Project Structure

The repository contains the following directories:

- `containers/nginx`: Contains the Dockerfile and configurations for the Nginx reverse proxy.
- `containers/laravel`: Contains the Dockerfile for the backend (Laravel).
- `mysql_data`: A folder to hold MySQL data.
- `Oktopost`: Mounted Laravel project code.

## Detailed info about task you can read in task README.md here:
   ```
   https://github.com/waitinghall/Assignment.git
   ```
