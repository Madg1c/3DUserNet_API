import os
import sys
import math
import time

import requests

MAX_UPLOAD_BYTE_LENGHT = 1024 * 1024 * 5 # 5M

HOST = '34.242.73.114'
PORT = 8080
API_URL = 'http://{}:{}'.format(HOST, PORT)

class Client:
    def __init__(self, api_url, max_byte_length):
        self.api_url = api_url
        self.max_byte_length = max_byte_length

    def upload_file(self, file_path):
        file_size = os.path.getsize(file_path)
        headers = {'Filename': os.path.basename(file_path)}        
        headers['Token'] = "cGFkbWluO0BhUzEyMzQ1NjsyMDE4LTAxLTMxIDEyOjUzOjM4LjE2MTczMg=="
        headers['Filesize'] = str(file_size)
        headers['Projectid'] = "735"
        headers['Arguments'] = "-a RGB INTENSITY --intensity-range 0 65535 --color-range 0 255"
        headers['filesize'] = str(file_size)
        with open(file_path, 'rb') as file:
            chunk_count = math.ceil(float(file_size) / self.max_byte_length)
            print("Total chunk count:", chunk_count)

            retry_timeout = 1
            sent_chunk_count = 0
            while True:
                headers['Range'] = "bytes={}/{}-{}".format(sent_chunk_count, int(chunk_count), file_size)

                data = file.read(self.max_byte_length)
                upload_endpoint = os.path.join(self.api_url, 'content', 'upload')

                try:
                    response = requests.post(upload_endpoint, headers=headers, data=data)
                    if response.ok:
                        print('{}. chunk sent to server'.format(sent_chunk_count + 1))
                        sent_chunk_count += 1
                except requests.exceptions.RequestException as e:
                    print('Error while sending chunk to server. Retrying in {} seconds'.format(retry_timeout))
                    print e
                    time.sleep(retry_timeout)

                    # Sleep for max 10 seconds
                    if retry_timeout < 10:
                        retry_timeout += 1
                    continue

                if sent_chunk_count >= chunk_count:
                    return True

            return False


if __name__ == '__main__':
    client = Client(API_URL, 

        MAX_UPLOAD_BYTE_LENGHT)

    try:
        file_path = sys.argv[1]
        print('Uploading file:', file_path)
        client.upload_file(file_path)
    except IndexError:
        print("No file path provided")
        print("Usage: python chunk_uploader.py [file_path]")
