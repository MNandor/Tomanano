package com.example.tomanano

import android.content.Intent
import android.os.Bundle
import android.util.Log
import androidx.appcompat.app.AppCompatActivity
import com.example.tomanano.retrofit.RetroRepo
import kotlinx.android.synthetic.main.activity_room.*
import android.widget.Toast

class Room : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_room)

        
        var resultInfo = intent.getIntExtra("result", 0) as Int

        if(resultInfo > 0){
            Log.d("Room", "This is return value, number of faces = ${resultInfo}")

            Thread(Runnable {
                var r = RetroRepo()
                var c = r.getRepo().sendRes(Login.myEmail!!, roomID!!, 1, resultInfo)


                var k = c.execute()


                var res = k.body()!!.responseCode


                runOnUiThread {
                    Toast.makeText(this@Room, res!!.toString(), Toast.LENGTH_LONG).show()
                }


            }).start()



        }else{
            Log.d("Room", "Error")
        }





        Thread(Runnable {
            var r = RetroRepo()
            var c = r.getRepo().getRooms(Login.myEmail!!)


            var k = c.execute()


            var rooms = k.body()!!

            if (rooms.size < 1)
                return@Runnable

            var room = rooms[0]
            roomID = room.roomID!!.toInt()

            runOnUiThread {
                addRoomName.text = room.roomName
                addRoomId.text = room.roomID
            }


        }).start()

        cameraButton.setOnClickListener {
            //@Endre do your thing here

            val intent = Intent(this, Camera::class.java)
            startActivity(intent)
        }
    }

    companion object{
        var roomID: Int? = null
    }
}