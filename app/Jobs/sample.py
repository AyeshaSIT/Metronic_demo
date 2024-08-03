import logging
import time
import random

def main():
    # Configure logger
    logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')
    # Add handler to stream log in the sample.log file
    file_handler = logging.FileHandler('sample.log')
    file_handler.setLevel(logging.INFO)
    formatter = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')
    file_handler.setFormatter(formatter)
    logging.getLogger().addHandler(file_handler)
    # Log a message
    logging.info('Start Job')
    logging.info('Hello, World!')
    # Sleep for a random duration between 1 and 2 minutes
    sleep_duration = random.randint(60, 120)
    logging.info(f'Sleeping for {sleep_duration} seconds')
    time.sleep(sleep_duration)
    logging.info('Job Completed')


    


if __name__ == '__main__':
    main()