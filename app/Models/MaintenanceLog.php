// File removed: MaintenanceLog.php (maintenance log system is deprecated and removed)
     */
    public function images(): HasMany
    {
        return $this->hasMany(MaintenanceImage::class, 'maintenance_id');
    }
}
