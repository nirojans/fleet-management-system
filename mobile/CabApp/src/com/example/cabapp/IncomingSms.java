package com.example.cabapp;

import com.example.cabapp.utils.CentralUtils;
import com.example.cabapp.utils.DbUtils;

import android.app.AlertDialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.net.Uri;
import android.os.Bundle;
import android.telephony.SmsManager;
import android.telephony.SmsMessage;
import android.util.Log;
import android.view.ViewDebug.FlagToString;
import android.widget.Toast;

public class IncomingSms extends BroadcastReceiver {
    
    // Get the object of SmsManager
    final SmsManager sms = SmsManager.getDefault();
  @Override
	public void onReceive(Context arg0, Intent arg1) {
		 final Bundle bundle = arg1.getExtras();
		 
	        try {
	             
	            if (bundle != null) {
	                 
	                final Object[] pdusObj = (Object[]) bundle.get("pdus");
	                 
	                for (int i = 0; i < pdusObj.length; i++) {
	                     
	                    SmsMessage currentMessage = SmsMessage.createFromPdu((byte[]) pdusObj[i]);
	                    String phoneNumber = currentMessage.getDisplayOriginatingAddress();
	                    
	                    final String senderNum = phoneNumber;
	                    final String message = currentMessage.getDisplayMessageBody();
	                   
	                    Log.i("SmsReceiver", "senderNum: "+ senderNum + "; message: " + message);
	                    final CentralUtils cu=CentralUtils.getInstance();
	                    DbUtils dbUtils=new DbUtils(arg0.getApplicationContext());
	                    cu.getGeoObject().setState("pending");
	                    dbUtils.addData("pending", "");
	                    Intent kl=new Intent(arg0, NotifySMS.class);
	                    kl.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
	                    kl.putExtra("message", message);
	                    kl.putExtra("senderNum", senderNum);
	    				arg0.startActivity(kl);
	                    
	    				/*Uri uri = Uri.parse("content://sms/inbox");
	    				Cursor cursor = arg0.getContentResolver().query(uri, null, null, null, null);
	    				cursor.moveToFirst();
	    				cursor.etString(cursor.getColumnIndex("read"))*/
	                   // Show Alert
	                    int duration = Toast.LENGTH_LONG;
	                   /* Toast toast = Toast.makeText(arg0,
                                "senderNum: "+ senderNum + ", message: " + message, duration);
	                    toast.show();*/
	                } 
	              } 
	 
	        } catch (Exception e) {
	            Log.e("SmsReceiver", "Exception smsReceiver" +e);
	             
	        }
	}   
}
