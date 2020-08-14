import os
import sys
import math
import time
import json
import requests

MAX_UPLOAD_BYTE_LENGHT = 1024 * 1024 * 5 # 5M

# Runs with Web2py server
HOST = 'upload.3dusernet.com'
#PORT = 8080
API_URL = 'https://{}'.format(HOST)

class Client:
    def __init__(self, api_url, max_byte_length):
        self.api_url = api_url
        self.max_byte_length = max_byte_length

    def upload_file(self, file_path, file_type, file_arg):
        file_size = os.path.getsize(file_path)
        headers = {'Filename': os.path.basename(file_path)}        
        headers['Token'] = "dHN0X2h1c3NhaW4yNDtAYVMxMjM0NTY7Z2VlaGRxOzIwMjAtMDgtMDYgMDc6NTY6MzMuMDQ5MDIz"
        headers['Filesize'] = str(file_size)
        headers['Projectid'] = "1391"
        headers['filesize'] = str(file_size)
        headers['Arguments'] = str(file_arg)
        headers['Filetype'] = str(file_type)
        print str(file_arg)
        print str(file_type)
        #headers['Arguments'] = "-a RGB INTENSITY --intensity-range 0 65535 --color-range 0 65535"
        #headers['Filetype'] = "PC"
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
		    json_data = json.loads(response.text)
                    if json_data["result"]=="success":
                        print('{}. chunk sent to server'.format(sent_chunk_count + 1))
                        sent_chunk_count += 1
		    else:
			print('Error Message:',json_data["message"])
			return False
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
        print "111111", sys.argv[0]
        file_path = sys.argv[1]
        print "222222"
        file_type = sys.argv[2]
        print "333333"
        file_arg = sys.argv[3]
        print 'Uploading file:', file_path
        client.upload_file(file_path, file_type, file_arg)
    except IndexError:
        print("No file path provided")
        print("Usage: python chunk_uploader.py [file_path]")
