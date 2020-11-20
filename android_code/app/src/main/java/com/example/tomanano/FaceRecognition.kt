package com.example.tomanano

interface FaceRecognition{

    val imageFileUrls : Collection<String>
    val numberOfimages : Int
    val numberOfDifferentFace : Int

    fun addImage(Url:String):Boolean
}