#!/usr/bin/env python
import pika

credentials = pika.PlainCredentials(username='admin', password='guest')
connection =  pika.BlockingConnection(pika.ConnectionParameters(host='10.0.0.24',
                                                      credentials=credentials))


channel = connection.channel()

channel.queue_declare(queue='hello')

channel.basic_publish(exchange='', routing_key='hello', body='Hello from Alex!')
print(" [x] Sent 'Hello World!'")
connection.close()
