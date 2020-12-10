package com.example.tomanano

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import com.example.tomanano.retrofit.RetroRepo
import kotlinx.android.synthetic.main.activity_login.*
import kotlinx.android.synthetic.main.activity_register.*

class Login : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_login)

        buttonLogToReg.setOnClickListener {
            startActivity(Intent(this, Register::class.java))
            overridePendingTransition(R.anim.slide_from_right, R.anim.slide_to_left)
        }
        buttonLogin.setOnClickListener {

            Thread(Runnable {
                var r = RetroRepo()
                var c = r.getRepo().login(loginEmailET.text.toString(),
                        loginPasswordET.text.toString())

                var k = c.execute()


                var code = k.body()!!.responseCode

                Log.i("fasz", code.toString())
                if (code != 0) //if successful
                {
                    myEmail = loginEmailET.text.toString()
                    startActivity(Intent(this, MainActivity::class.java))
                }

            }).start()
        }
    }

    companion object{
        var myEmail: String? = null
    }
}