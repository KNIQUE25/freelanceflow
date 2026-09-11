<?php namespace App\Models;
 use Illuminate\Database\Eloquent\Factories\HasFactory; 
 use Illuminate\Foundation\Auth\User as Authenticatable;
  use Illuminate\Notifications\Notifiable; 
  use Laravel\Sanctum\HasApiTokens; 

  class User extends Authenticatable {
     use HasApiTokens, HasFactory, Notifiable; 
     protected $fillable = [ 'name', 'email', 'password', 'role', 'suspended_at', ];
      protected $hidden = [ 'password', 'remember_token', ]; 
      protected function casts(): array {
         return [ 'email_verified_at' => 'datetime', 'password' => 'hashed', 'suspended_at' => 'datetime', ]; }
          /** * Clients belonging to this user. */ 
          public function clients() {
             return $this->hasMany(Client::class); }
              /** * Invoices belonging to this user. */ 
              public function invoices() { 
                return $this->hasMany(Invoice::class); }
                 /** * Business profile belonging to this user. */ 
                 public function businessProfile() { 
                    
                 return $this->hasOne(BusinessProfile::class); } 
                 /** * Audit logs belonging to this user. */ 
                 public function auditLogs() {
                     return $this->hasMany(AuditLog::class); }
                      }