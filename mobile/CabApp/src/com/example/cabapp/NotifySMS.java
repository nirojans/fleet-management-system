package com.example.cabapp;

import com.example.cabapp.utils.CentralUtils;
import com.example.cabapp.utils.DataManipulationUtils;
import com.example.cabapp.utils.DbUtils;

import android.os.Bundle;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.BroadcastReceiver;
import android.content.ComponentName;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.pm.PackageManager;
import android.telephony.SmsManager;
import android.telephony.SmsMessage;
import android.util.Log;
import android.view.Menu;

public class NotifySMS extends Activity {

	private static final String LOG_TAG = "SMSReceiver";
    public static final int NOTIFICATION_ID_RECEIVED = 0x1221;
    static final String ACTION = "android.provider.Telephony.SMS_RECEIVED";
    Activity myActivity;
    CentralUtils cu=CentralUtils.getInstance();
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        myActivity=this;
        final SmsManager sms = SmsManager.getDefault();
        final String message=this.getIntent().getStringExtra("message");
        final String senderNum=this.getIntent().getStringExtra("senderNum");
        final DbUtils db = new DbUtils(getApplicationContext());
        final DataManipulationUtils dataManipulationUtils=new DataManipulationUtils();
        String [] preAr = dataManipulationUtils.readDetailsFromSMS(message);
        if(Integer.parseInt(preAr[0])==1){
        AlertDialog ad= new AlertDialog.Builder(this)
        .setTitle("New Order")
        .setCancelable(false)
        .setMessage(message+" Accept This?")
        .setPositiveButton(android.R.string.yes, new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int which) { 
            	 String [] ar = dataManipulationUtils.readDetailsFromSMS(message);
            	 /// Set vcancel validation Logic 
            	 cu.getGeoObject().setHash(ar[2]);
            	 cu.getGeoObject().setHashCode(ar[4]);
            	 cu.getGeoObject().setState("accepted");
            	 cu.getGeoObject().setDriverID(ar[3]);
            	 cu.getGeoObject().setCurrentOrderID(ar[1]);
            	 Log.d("aawa","order id :"+ ar[1]);
            	 sms.sendTextMessage(senderNum, null, "Order Accepted :)", null, null);
            	           	 myActivity.finish();
            	 db.addData("accepted",ar[1]);
            	Intent i = new Intent(getApplicationContext(),
 						UserActivity.class);
            	startActivity(i); 
            }
         })
        .setNegativeButton(android.R.string.no, new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int which) { 
            	sms.sendTextMessage(senderNum, null, "Order not Accepted :(", null, null);
            	db.addData("idle", db.getOrderid());
            	cu.getGeoObject().setState("idle");
            	myActivity.finish();
            }
         })
        .setIcon(android.R.drawable.ic_dialog_alert)
        .show();
     }else{
    	 AlertDialog ad= new AlertDialog.Builder(this)
         .setTitle("New Order")
         .setCancelable(false)
         .setMessage(preAr[2]+"This order has been cancelled .")
         .setPositiveButton(android.R.string.yes, new DialogInterface.OnClickListener() {
             public void onClick(DialogInterface dialog, int which) { 
             	/// Set vcancel validation Logic 
             	 cu.getGeoObject().setHash("");
             	 cu.getGeoObject().setHashCode("");
             	 cu.getGeoObject().setState("idle");
             	 db.addData("idle", "");
             	 cu.getGeoObject().setDriverID("");   ///////////check this
             	 myActivity.finish();
             	cu.getUserActivity().finish();
             }
          })         
         .setIcon(android.R.drawable.ic_dialog_alert)
         .show();
      }
     
        
    }
    
    
}
