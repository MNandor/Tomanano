package com.example.tomanano

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import com.example.tomanano.retrofit.RetroRepo
import kotlinx.android.synthetic.main.activity_register.*

class Register : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_register)

        buttonRegToLog.setOnClickListener {
            //onBackPressed()
            //startActivity(Intent(this,Login::class.java))

            Thread(Runnable {
                var r = RetroRepo()
                var c = r.getRepo().register(registerNameET.text.toString(),
                    registerEmailET.text.toString(), registerPasswordET.text.toString())

                var k = c.execute()

                Log.i("ducks", k.body()!!.responseCode.toString())



            }).start()
        }

        fun onBackPressed() {
            super.onBackPressed()
            overridePendingTransition(R.anim.slide_from_left,R.anim.slide_to_right)
        }
    }
}