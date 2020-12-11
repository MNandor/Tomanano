package com.example.tomanano


import android.content.ActivityNotFoundException
import android.content.Intent
import android.graphics.Bitmap
import android.graphics.BitmapFactory
import android.graphics.Matrix
import android.media.ExifInterface
import android.net.Uri
import android.os.Bundle
import android.os.Environment
import android.provider.MediaStore
import android.util.Log
import android.widget.Button
import android.widget.ImageView
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity
import androidx.core.content.FileProvider
import com.google.firebase.ml.vision.FirebaseVision
import com.google.firebase.ml.vision.common.FirebaseVisionImage
import com.google.firebase.ml.vision.face.FirebaseVisionFaceDetectorOptions
import kotlinx.android.synthetic.main.activity_camera.*
import kotlinx.android.synthetic.main.activity_login.*
import java.io.File
import java.io.IOException
import java.sql.Date
import java.text.SimpleDateFormat


class Camera : AppCompatActivity() {


    val REQUEST_IMAGE_CAPTURE = 1
    lateinit var currentPhotoPath: String
    lateinit var imageView : ImageView
    lateinit var button : Button
    var countofFace : Int = 0
    lateinit var back : Button
    var isStop : Boolean = false
    lateinit var resultView : TextView


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_camera)

        button = findViewById(R.id.button)

        Log.d("Camera", "${button.text}")

        button.setOnClickListener(){

            if(!isStop){

                Log.d("Camera", "TAKE A PHOTO")
                dispatchTakePictureIntent2()

            }
        }

        back = findViewById(R.id.back)

        back.setOnClickListener(){


            if(!isStop){

                val intent = Intent(this, Room::class.java)

                if(back.text == "Back"){
                    intent.putExtra("result", 0)
                }else{
                    intent.putExtra("result", countofFace)
                }

                startActivity(intent)
                //finish();
            }
        }
    }


    private fun dispatchTakePictureIntent() {
        val takePictureIntent = Intent(MediaStore.ACTION_IMAGE_CAPTURE)
        try {
            startActivityForResult(takePictureIntent, REQUEST_IMAGE_CAPTURE)
        } catch (e: ActivityNotFoundException) {
            // display error state to the user
        }
    }


    fun rotateImage(source: Bitmap, angle: Float): Bitmap {
        val matrix = Matrix()
        matrix.postRotate(angle)
        return Bitmap.createBitmap(
                source, 0, 0, source.width, source.height,
                matrix, true
        )
    }



    fun getRotateCurrentPhoto(bitmap: Bitmap) : Bitmap {

        val ei: ExifInterface = ExifInterface(currentPhotoPath)
        val orientation = ei.getAttributeInt(
                ExifInterface.TAG_ORIENTATION,
                ExifInterface.ORIENTATION_UNDEFINED
        )

        lateinit var rotatedBitmap : Bitmap

        when (orientation) {
            ExifInterface.ORIENTATION_ROTATE_90 -> rotatedBitmap = rotateImage(bitmap, 90F)
            ExifInterface.ORIENTATION_ROTATE_180 -> rotatedBitmap = rotateImage(bitmap, 180F)
            ExifInterface.ORIENTATION_ROTATE_270 -> rotatedBitmap = rotateImage(bitmap, 270F)
            ExifInterface.ORIENTATION_NORMAL -> rotatedBitmap = bitmap
            else -> rotatedBitmap = bitmap
        }
        return rotatedBitmap
    }


    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == REQUEST_IMAGE_CAPTURE && resultCode == RESULT_OK) {

            isStop = true
            resultView = findViewById(R.id.result)
            resultView.setText("Image processing ")

            val imageBitmap = getRotateCurrentPhoto(BitmapFactory.decodeFile(currentPhotoPath))

           // val imageBitmap = data?.extras?.get("data") as Bitmap

            imageView = findViewById(R.id.imageView)
            imageView.setImageBitmap(imageBitmap)

            val highAccuracyOpts = FirebaseVisionFaceDetectorOptions.Builder()
                .setPerformanceMode(FirebaseVisionFaceDetectorOptions.ACCURATE)
                .setLandmarkMode(FirebaseVisionFaceDetectorOptions.ALL_LANDMARKS)
                .setClassificationMode(FirebaseVisionFaceDetectorOptions.NO_CLASSIFICATIONS)
                .build()


            val detector = FirebaseVision.getInstance()
                .getVisionFaceDetector(highAccuracyOpts)

            val image = FirebaseVisionImage.fromBitmap(imageBitmap)

            val result = detector.detectInImage(image)
                .addOnSuccessListener { faces ->
                    Log.d("Camere", "True")
                    Log.d("Camere", "${faces.size}")
                    countofFace = faces.size
                    resultView.setText("CountOfFaces: ${countofFace}")
                    back = findViewById(R.id.back)
                    back.setText("OK")
                    isStop = false


                }
                .addOnFailureListener { e ->
                    Log.d("Camere", "Error face detect")
                    resultView.setText("Sorry, try again")
                    isStop = false
                }
        }
    }



    @Throws(IOException::class)
    private fun createImageFile(): File {
        // Create an image file names
        val timeStamp: String = SimpleDateFormat("yyyyMMdd_HHmmss").format(Date(12))
        val storageDir: File? = getExternalFilesDir(Environment.DIRECTORY_PICTURES)
        return File.createTempFile(
                "JPEG_${timeStamp}_", /* prefix */
                ".jpg", /* suffix */
                storageDir /* directory */
        ).apply {
            // Save a file: path for use with ACTION_VIEW intents
            currentPhotoPath = absolutePath
        }
    }


    private fun dispatchTakePictureIntent2() {
        Intent(MediaStore.ACTION_IMAGE_CAPTURE).also { takePictureIntent ->
            // Ensure that there's a camera activity to handle the intent
            takePictureIntent.resolveActivity(packageManager)?.also {
                // Create the File where the photo should go
                val photoFile: File? = try {
                    createImageFile()
                } catch (ex: IOException) {
                    // Error occurred while creating the File
                    null
                }
                // Continue only if the File was successfully created
                photoFile?.also {
                    val photoURI: Uri = FileProvider.getUriForFile(
                            this,
                            "com.example.tomanano.fileprovider",
                            it
                    )
                    takePictureIntent.putExtra(MediaStore.EXTRA_OUTPUT, photoURI)
                    startActivityForResult(takePictureIntent, REQUEST_IMAGE_CAPTURE)
                }
            }
        }
    }


}