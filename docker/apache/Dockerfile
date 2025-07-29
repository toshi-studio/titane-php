FROM httpd:2.4-alpine

# Install SSL support
RUN apk add --no-cache openssl

# Create necessary directories
RUN mkdir -p /etc/apache2/ssl /var/log/apache2

# Copy SSL certificates
COPY ssl/selfsigned.crt /etc/apache2/ssl/selfsigned.crt
COPY ssl/selfsigned.key /etc/apache2/ssl/selfsigned.key

# Remove default configuration
RUN rm -f /usr/local/apache2/conf/httpd.conf

# Copy our minimal configuration
COPY httpd-minimal.conf /usr/local/apache2/conf/httpd.conf

# Copy VirtualHost configuration
COPY apache.conf /usr/local/apache2/conf/extra/vhosts.conf

# Create document root
RUN mkdir -p /var/www/html/public

# Expose ports
EXPOSE 80 443