<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Announcement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4f46e5;
            color: #ffffff;
            padding: 24px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }
        .content {
            padding: 24px;
            line-height: 1.6;
        }
        .announcement-title {
            font-size: 18px;
            font-weight: bold;
            color: #1e293b;
            margin-top: 0;
            margin-bottom: 12px;
        }
        .announcement-meta {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 20px;
        }
        .announcement-body {
            font-size: 14px;
            color: #334155;
            white-space: pre-line;
            background: #f1f5f9;
            padding: 16px;
            border-radius: 6px;
        }
        .footer {
            padding: 16px 24px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #64748b;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Announcement</h1>
        </div>
        <div class="content">
            <h2 class="announcement-title">{{ $announcement->title }}</h2>
            <div class="announcement-meta">
                Posted by Teacher <strong>{{ $announcement->user->name }}</strong> on {{ $announcement->created_at->format('M d, Y H:i') }}
            </div>
            <div class="announcement-body">
                {{ $announcement->description }}
            </div>
        </div>
        <div class="footer">
            This is an automated notification. Please do not reply directly to this email.
        </div>
    </div>
</body>
</html>
