# Python program for face 
# comparision 


from __future__ import print_function, unicode_literals 
from facepplib import FacePP, exceptions 


### define global variables 
##face_detection = "" 
##faceset_initialize = "" 
##face_search = "" 
##face_landmarks = "" 
##dense_facial_landmarks = "" 
##face_attributes = "" 
##beauty_score_and_emotion_recognition = "" 

# define face comparing function 
def face_comparing(app, Image1, Image2): 
	
	cmp_ = app.compare.get(image_url1 = Image1, 
						image_url2 = Image2) 

	print('Photo1', '=', cmp_.image1) 
	print('Photo2', '=', cmp_.image2) 

	# Comparing Photos 
	if cmp_.confidence > 70: 
		print('Both photographs are of same person......') 
	else: 
		print('Both photographs are of two different persons......') 

		
# Driver Code 
if __name__ == '__main__': 

	# api details 
	api_key ='xQLsTmMyqp1L2MIt7M3l0h-cQiy0Dwhl'
	api_secret ='TyBSGw8NBEP9Tbhv_JbQM18mIlorY6-D'

	try: 

		# call api 
		app_ = FacePP(api_key = api_key, 
					api_secret = api_secret) 
##		funcs = [ 
##			face_detection, 
##			face_comparing_localphoto, 
##			face_comparing_websitephoto, 
##			faceset_initialize, 
##			face_search, 
##			face_landmarks, 
##			dense_facial_landmarks, 
##			face_attributes, 
##			beauty_score_and_emotion_recognition 
##		] 
		
		# Pair 1 
		image1 = './image/img1'
		image2 = './image/img2'
		face_comparing(app_, image1, image2) 
			 
	except exceptions.BaseFacePPError as e: 
		print('Error:', e) 
