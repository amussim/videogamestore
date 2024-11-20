# Video Game Store Web Application

## Overview
The Video Game Store web application is an online retail platform that specializes in selling video games, accessories, and associated hardware. This application provides customers with the ability to create accounts, browse products, make purchases, submit reviews, and give feedback on their experiences. In addition to customer functionalities, the platform allows administrators to manage product listings and review customer feedback.

The platform includes the following main features:
- **User Account Management**: Customers can register, log in, and manage their accounts.
- **Product Listings**: Customers can view available products, including video games and accessories, with details such as price, type, and stock.
- **Order Management**: Users can view their order history and track the status of their purchases.
- **Customer Feedback**: Customers can submit feedback on their experiences, which is accessible to administrators for quality improvement.

This project is deployed using Docker, providing an easy setup and consistent environment for development and production.

## Features

### 1. Customer Dashboard
- **Product Browsing**: Users can browse and view detailed information about products available in the store.
- **Order Management**: Users can view their past orders and check the status of any new purchases.
- **Profile Management**: Users can update their personal details and preferences.
- **Submit Feedback**: Customers can submit their feedback on products and the overall store experience.

### 2. Admin Dashboard
- **Product Management**: Admins can add, edit, or remove products from the store.
- **Feedback Review**: Admins can view customer feedback to address concerns and improve service quality.

### 3. Feedback System
- Customers can rate their experience and leave comments about products or services.
- Admins can review all feedback to identify areas for improvement.

## Docker Setup
This application is containerized using Docker, which makes it easy to set up and run in any environment. Below are the steps to use Docker to manage the application:

### 1. Building the Docker Image
To build the Docker image for the Video Game Store application, use the following command:
```sh
docker build -t videogamestore:latest .
```
This command will create a Docker image named `videogamestore` with the tag `latest`.

### 2. Running the Container
After building the image, you can run the container using:
```sh
docker run -d -p 8080:80 --name videogamestore-container videogamestore:latest
```
This command will run the container in detached mode (`-d`) and bind port `8080` on your host machine to port `80` inside the container. The container will be named `videogamestore-container`.

### 3. Stopping and Removing the Container
If you need to stop the running container, use:
```sh
docker stop videogamestore-container
```
To remove the container after stopping it, use:
```sh
docker rm videogamestore-container
```

### 4. Modifying Code and Rebuilding the Container (If Necessary)
If you need to make changes to the PHP code or any part of the application, follow these steps:

1. **Update the files locally** with your desired changes.
2. **Rebuild the Docker image** to include these changes:
   ```sh
   docker build -t videogamestore:latest .
   ```
3. **Stop the old container** and **start a new one** to see the changes:
   ```sh
   docker stop videogamestore-container
   docker rm videogamestore-container
   docker run -d -p 8080:80 --name videogamestore-container videogamestore:latest
   ```

By following these steps, you can make iterative changes to your application and quickly redeploy it.

## Prerequisites
- **Docker**: Ensure Docker is installed on your system.
- **PHP and MySQL**: The application uses PHP for server-side logic and MySQL for the database.

## Usage
1. **Access the Application**: Once the Docker container is running, you can access the application in your browser at `http://localhost:8080`.
2. **Register as a Customer**: Use the registration page to create a new customer account.
3. **Admin Functionalities**: Log in as an administrator to manage product listings and view customer feedback.
4. **Submit Feedback**: Customers can submit feedback about their experience, which will be visible to administrators for review.

## Troubleshooting
- **Error Accessing the Application**: Make sure the Docker container is running and accessible on the correct port (`8080`).
- **Changes Not Reflected**: If you've modified the code, make sure to rebuild the Docker image and restart the container.

## Conclusion
The Video Game Store application provides an efficient way to manage an online retail store specializing in video games and accessories. Using Docker ensures a seamless deployment and consistent environment across different setups, making it easy for developers to iterate and improve the platform.

