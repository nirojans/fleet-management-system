package com.example.cabapp.utils;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

public class DbUtils extends SQLiteOpenHelper {
	private static final int DbVersion = 1;
	private static final String DbName = "Cache_Database";
	private static final String TableName = "cachetable";
	private static final String colid = "id";
	private static final String colvalue = "data";
	private static final String colorderid = "orderid";

	public DbUtils(Context context) {
		super(context, DbName, null, DbVersion);
	}

	@Override
	public void onCreate(SQLiteDatabase db) {
		String sqlQuerry = "CREATE TABLE " + TableName + "(" + colid
				+ " INTEGER PRIMARY KEY," + colvalue
				+ " TEXT," + colorderid
				+ " TEXT)";
		db.execSQL(sqlQuerry);
		init(db);
	}

	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
		db.execSQL("DROP TABLE IF EXISITS" + TableName);
		onCreate(db);
	}

	public void addData(String data,String orderid) {
		int id=1;
		SQLiteDatabase db = this.getWritableDatabase();
		ContentValues cv = new ContentValues();
		cv.put(colvalue, data);
		cv.put(colorderid, orderid);
		db.update(TableName, cv, "id=" + id, null);
		db.close();
	}

	public void init(SQLiteDatabase db) {
		ContentValues cv = new ContentValues();
		cv.put(colid, 1);
		cv.put(colvalue, "idle");
		cv.put(colorderid, "");
		db.insert(TableName, null, cv);
	}

	public String getState() {
		SQLiteDatabase db = this.getReadableDatabase();
		Cursor cursor = db.query(TableName, new String[] { colid,
				colvalue,colorderid }, colid + "=?", new String[] { String.valueOf(1) },
				null, null, null, null);
		if (cursor != null)
			cursor.moveToFirst();
		String result=cursor.getString(1);
		cursor.close();
		db.close();
		return result;
	}
	
	public String getOrderid() {
		SQLiteDatabase db = this.getReadableDatabase();
		Cursor cursor = db.query(TableName, new String[] { colid,
				colvalue,colorderid }, colid + "=?", new String[] { String.valueOf(1) },
				null, null, null, null);
		if (cursor != null)
			cursor.moveToFirst();
		String result=cursor.getString(2);
		cursor.close();
		db.close();
		return result;
	}

	public String getData() {
		SQLiteDatabase db = this.getReadableDatabase();
		Cursor cursor = db.rawQuery("SELECT * FROM cachetable WHERE id=1" ,
				null);
		if (cursor != null)
			cursor.moveToFirst();
		return cursor.getString(1);
	}
}
